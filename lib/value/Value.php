<?php

namespace YformSeeder\Value;

use YformSeeder\Utilities;

abstract class Value
{
    abstract public static function createValueField(): void;

    protected static array $attributes = [
        'list_hidden' => 1,
        'search' => 0,
        'table_name' => ''
    ];
    public static string $tableName;
    public static string $name;
    public static string $label;

    /**
     * create a new value field
     * @param string $tableName
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public static function create(string $tableName, string $name, string $label, array $attributes = []): void {
        if (!$tableName) {
           throw new \rex_exception('You must provide a table name');
        }

        $tableName = Utilities::normalize(Utilities::sanitize($tableName));
        $name = Utilities::normalize(Utilities::sanitize($name));
        $label = Utilities::sanitize($label);

        self::$tableName = $tableName;
        self::$name = $name;
        self::$label = $label;
        self::$attributes = array_merge(self::$attributes, $attributes);
        self::$attributes['table_name'] = $tableName;

        static::createValueField();
    }

    /**
     * create a new value field
     * @param array $attributes
     * @return void
     * @throws \rex_sql_exception
     */
    public static function insert(array $attributes = []): void {
        self::insertField($attributes);
        self::insertYFormField($attributes);
    }

    /**
     * create a new value field
     * @param array $attributes
     * @return void
     * @throws \rex_sql_exception
     */
    public static function insertField(array $attributes = []): void {
        $sql = \rex_sql::factory();

        $query = 'SHOW COLUMNS FROM ' . self::$tableName . ' LIKE "' . self::$name . '"';
        $fieldCount = $sql->setQuery($query)->getRows();

        /** field already exists - return early */
        if($fieldCount) {
            return;
        }

        $columns = \rex_sql_table::get(self::$tableName)->getColumns();
        $after = null;

        if($columns) {
            /** @var \rex_sql_column $after */
            $after = end($columns)->getName();
        }

        \rex_sql_table::get(self::$tableName)
            ->ensureColumn(new \rex_sql_column(self::$name, $attributes['db_type']), $after)
            ->ensure();
    }

    /**
     * create a new value field
     * @param array $attributes
     * @return void
     * @throws \rex_sql_exception
     */
    public static function insertYFormField(array $attributes = []): void {
        $yformTable = \rex::getTable('yform_field');
        $sql = \rex_sql::factory();

        $query = 'SELECT id FROM ' . $yformTable;
        $query .= ' WHERE name = ? AND table_name = ? AND type_id = ?';
        $fieldId = $sql->getArray($query, [self::$name, self::$tableName, $attributes['type_id']], \PDO::FETCH_COLUMN);

        $prio = $sql->getArray('SELECT MAX(prio) AS max FROM ' . $yformTable . ' WHERE table_name = ?', [self::$tableName]);

        /** set field prio */
        if(!empty($prio)) {
            $prio = $prio[0]['max'] + 1;
        }
        else {
            $prio = 0;
        }

        /** field already exists - return early */
        if($fieldId) {
            return;
        }

        $attributes['name'] = self::$name;
        $attributes['label'] = self::$label;
        $attributes['prio'] = $prio;

        $sql->setTable($yformTable);

        foreach ($attributes as $key => $value) {
            $sql->setValue($key, $value);
        }

        $sql->insert();
        \rex_yform_manager_table::deleteCache();
    }

    /**
     * @throws \rex_exception
     */
    public static function throwTypeNotSupportedException(string $type = ''): void {
        throw new \rex_exception('db_type ' . $type . ' not supported for ' . self::$name);
    }
}