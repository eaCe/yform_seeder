<?php

namespace YformSeeder;

class Table
{
    /** @var array|string[]  */
    private static array $attributes = [
        'status' => '1',
        'table_name' => '',
        'name' => '',
        'description' => '',
        'list_amount' => '50',
        'list_sortfield' => 'id',
        'list_sortorder' => 'DESC',
        'search' => '0',
        'hidden' => '0',
        'add_new' => '0',
        'export' => '0',
        'import' => '0',
        'mass_deletion' => '0',
        'mass_edit' => '0',
        'schema_overwrite' => '0',
        'history' => '0'
    ];

    /**
     * create a new table set and import/install it
     * @param string $tableName
     * @param string $name
     * @param array|string[] $tableAttributes
     * @return void
     * @throws \JsonException
     * @throws \rex_sql_exception
     */
    public static function create(string $tableName, string $name, array $tableAttributes = []): void {
        $tableAttributes['table_name'] = Utilities::normalize(Utilities::sanitize($tableName));
        $tableAttributes['name'] = Utilities::sanitize($name);

        $tableAttributes = array_merge(self::$attributes, $tableAttributes);
        $tableSet = [
            $tableAttributes['table_name'] => [
                'table' => $tableAttributes,
                'fields' => [],
            ]
        ];

        self::installTableSet(json_encode($tableSet, JSON_THROW_ON_ERROR));
    }

    /**
     * import/install the given table set
     * @param string $tableSet
     * @return void
     * @throws \rex_sql_exception
     */
    private static function installTableSet(string $tableSet): void {
        \rex_yform_manager_table_api::importTablesets($tableSet);
    }
}