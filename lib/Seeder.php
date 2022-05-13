<?php

namespace YformSeeder;

use YformSeeder\Value\BeLink;
use YformSeeder\Value\BeMedia;
use YformSeeder\Value\BeTable;
use YformSeeder\Value\BeUser;
use YformSeeder\Value\Choice;
use YformSeeder\Value\Date;
use YformSeeder\Value\Datestamp;
use YformSeeder\Value\Email;
use YformSeeder\Value\Integer;
use YformSeeder\Value\IP;
use YformSeeder\Value\Number;
use YformSeeder\Value\Text;
use YformSeeder\Value\TextArea;
use YformSeeder\Value\Time;
use YformSeeder\Value\Upload;
use YformSeeder\Value\Uuid;
use YformSeeder\Value\Value;

class Seeder
{
    private array $fieldAttributes = [];
    private ?string $lastInsertedColumnName = null;
    /**
     * the table name
     */
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name) {
        $this->name = Utilities::normalize(Utilities::sanitize($name));
    }

    /**
     * @param string $tableName the table name
     * @return Seeder
     */
    public static function factory(string $tableName): Seeder {
        return new self($tableName);
    }

    /**
     * @return void
     * @throws \rex_exception
     */
    public function create() {
        if (!$this->name) {
            throw new \rex_exception('You must provide a table name');
        }

        foreach ($this->fieldAttributes as $attributes) {
            $this->insert($attributes);
        }
    }

    /**
     * create a new value field
     * @param array $attributes
     * @return void
     * @throws \rex_sql_exception
     */
    private function insert(array $attributes): void {
        $this->insertField($attributes);
        $this->insertYFormField($attributes);
    }

    /**
     * create a new value field
     * @param array $attributes
     * @return void
     * @throws \rex_sql_exception
     */
    private function insertField(array $attributes): void {
        $sql = \rex_sql::factory();

        $query = 'SHOW COLUMNS FROM ' . $this->name . ' LIKE "' . $attributes['name'] . '"';
        $fieldCount = $sql->setQuery($query)->getRows();

        /** field already exists - return early */
        if($fieldCount) {
            return;
        }

        $after = null;

        if($this->lastInsertedColumnName) {
            $after = $this->lastInsertedColumnName;
        }

        \rex_sql_table::get($this->name)
            ->ensureColumn(new \rex_sql_column($attributes['name'], $attributes['db_type']), $after)
            ->ensure();

        $this->lastInsertedColumnName = $attributes['name'];
    }

    /**
     * create a new value field
     * @param array $attributes
     * @return void
     * @throws \rex_sql_exception
     */
    private function insertYFormField($attributes): void {
        $yformTable = \rex::getTable('yform_field');
        $sql = \rex_sql::factory();
        $attributes['table_name'] = $this->name;

        $query = 'SELECT id FROM ' . $yformTable;
        $query .= ' WHERE name = ? AND table_name = ? AND type_id = ?';
        $fieldId = $sql->getArray($query, [$attributes['name'], $this->name, $attributes['type_id']], \PDO::FETCH_COLUMN);

        $prio = $sql->getArray('SELECT MAX(prio) AS max FROM ' . $yformTable . ' WHERE table_name = ?', [$this->name]);

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

        $attributes['prio'] = $prio;

        $sql->setTable($yformTable);

        foreach ($attributes as $key => $value) {
            $sql->setValue($key, $value);
        }

        $sql->insert();
        \rex_yform_manager_table::deleteCache();
    }

    /**
     * create a text value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function text(string $name, string $label = '', array $attributes = []): void {
        $value = new Text($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a textarea value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function textarea(string $name, string $label = '', array $attributes = []): void {
        $value = new TextArea($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a be_link value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function beLink(string $name, string $label = '', array $attributes = []): void {
        $value = new BeLink($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a be_media value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function beMedia(string $name, string $label = '', array $attributes = []): void {
        $value = new BeMedia($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a be_table value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function beTable(string $name, string $label = '', array $attributes = []): void {
        $value = new BeTable($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a be_user value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function beUser(string $name, string $label = '', array $attributes = []): void {
        $value = new BeUser($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a choice value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function choice(string $name, string $label = '', array $attributes = []): void {
        $value = new Choice($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a date value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function date(string $name, string $label = '', array $attributes = []): void {
        $value = new Date($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a datestamp value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function datestamp(string $name, string $label = '', array $attributes = []): void {
        $value = new Datestamp($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a email value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function email(string $name, string $label = '', array $attributes = []): void {
        $value = new Email($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a int value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function integer(string $name, string $label = '', array $attributes = []): void {
        $value = new Integer($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a time value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function time(string $name, string $label = '', array $attributes = []): void {
        $value = new Time($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a ip value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function ip(string $name, string $label = '', array $attributes = []): void {
        $value = new IP($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a number value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function number(string $name, string $label = '', array $attributes = []): void {
        $value = new Number($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a upload value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function upload(string $name, string $label = '', array $attributes = []): void {
        $value = new Upload($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * create a uuid value field
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return void
     * @throws \rex_exception
     */
    public function uuid(string $name, string $label = '', array $attributes = []): void {
        $value = new Uuid($name, $label, $attributes);
        $this->addAttributes($value->attributes);
    }

    /**
     * @param array $attributes
     * @return void
     */
    private function addAttributes(array $attributes) {
        $this->fieldAttributes[] = $attributes;
    }
}