<?php

namespace YformSeeder;

use YformSeeder\Validate\Compare;
use YformSeeder\Validate\CompareValue;
use YformSeeder\Validate\EmptyValidate;
use YformSeeder\Validate\IntFromTo;
use YformSeeder\Validate\PasswordPolicy;
use YformSeeder\Validate\PregMatch;
use YformSeeder\Validate\Size;
use YformSeeder\Validate\SizeRange;
use YformSeeder\Validate\Type;
use YformSeeder\Validate\Unique;
use YformSeeder\Value\BeLink;
use YformSeeder\Value\BeMedia;
use YformSeeder\Value\BeTable;
use YformSeeder\Value\BeUser;
use YformSeeder\Value\Checkbox;
use YformSeeder\Value\Choice;
use YformSeeder\Value\Date;
use YformSeeder\Value\Datestamp;
use YformSeeder\Value\DateTime;
use YformSeeder\Value\Email;
use YformSeeder\Value\Html;
use YformSeeder\Value\ImageList;
use YformSeeder\Value\Integer;
use YformSeeder\Value\IP;
use YformSeeder\Value\Number;
use YformSeeder\Value\ShowValue;
use YformSeeder\Value\Text;
use YformSeeder\Value\TextArea;
use YformSeeder\Value\Time;
use YformSeeder\Value\Upload;
use YformSeeder\Value\Uuid;

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
        if($attributes['db_type'] === 'none' || $attributes['db_type'] === '' || $attributes['type_id'] === 'validate') {
            return;
        }

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
        $fieldId = null;

        if($attributes['type_id'] === 'value') {
            $query = 'SELECT id FROM ' . $yformTable;
            $query .= ' WHERE name = ? AND table_name = ? AND type_id = ?';
            $fieldId = $sql->getArray($query, [$attributes['name'], $this->name, $attributes['type_id']], \PDO::FETCH_COLUMN);
        }

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

        /**
         * create missing columns
         */
        \rex_yform_manager_table_api::createMissingFieldColumns($attributes);

        $sql->setTable($yformTable);

        foreach ($attributes as $key => $value) {
            $sql->setValue($key, $value);
        }

        $sql->insert();
        \rex_yform_manager_table::deleteCache();
    }

    /**
     * create a text value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Text
     */
    public function text(string $name, string $label = '', array $attributes = []): Text {
        $value = new Text($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a textarea value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return TextArea
     */
    public function textarea(string $name, string $label = '', array $attributes = []): TextArea {
        $value = new TextArea($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a be_link value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return BeLink
     */
    public function beLink(string $name, string $label = '', array $attributes = []): BeLink {
        $value = new BeLink($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a be_media value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return BeMedia
     */
    public function beMedia(string $name, string $label = '', array $attributes = []): BeMedia {
        $value = new BeMedia($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a imagelist value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return ImageList
     */
    public function imageList(string $name, string $label = '', array $attributes = []): ImageList {
        $value = new ImageList($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a be_table value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return BeTable
     */
    public function beTable(string $name, string $label = '', array $attributes = []): BeTable {
        $value = new BeTable($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a be_user value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return BeUser
     */
    public function beUser(string $name, string $label = '', array $attributes = []): BeUser {
        $value = new BeUser($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a choice value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Choice
     */
    public function choice(string $name, string $label = '', array $attributes = []): Choice {
        $value = new Choice($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a checkbox value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Checkbox
     */
    public function checkbox(string $name, string $label = '', array $attributes = []): Checkbox {
        $value = new Checkbox($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a date value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Date
     */
    public function date(string $name, string $label = '', array $attributes = []): Date {
        $value = new Date($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a datetime value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return DateTime
     */
    public function dateTime(string $name, string $label = '', array $attributes = []): DateTime {
        $value = new DateTime($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a datestamp value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Datestamp
     */
    public function datestamp(string $name, string $label = '', array $attributes = []): Datestamp {
        $value = new Datestamp($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a email value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Email
     */
    public function email(string $name, string $label = '', array $attributes = []): Email {
        $value = new Email($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a int value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Integer
     */
    public function integer(string $name, string $label = '', array $attributes = []): Integer {
        $value = new Integer($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a time value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Time
     */
    public function time(string $name, string $label = '', array $attributes = []): Time {
        $value = new Time($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a ip value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return IP
     */
    public function ip(string $name, string $label = '', array $attributes = []): IP {
        $value = new IP($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a number value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Number
     */
    public function number(string $name, string $label = '', array $attributes = []): Number {
        $value = new Number($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a upload value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Upload
     */
    public function upload(string $name, string $label = '', array $attributes = []): Upload {
        $value = new Upload($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a uuid value field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Uuid
     */
    public function uuid(string $name, string $label = '', array $attributes = []): Uuid {
        $value = new Uuid($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a html field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     * @return Html
     */
    public function html(string $name, string $label = '', array $attributes = []): Html {
        $value = new Html($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a showvalue field
     *
     * @param string $name
     * @param string $label
     * @param array $attributes
     * @return ShowValue
     * @throws \rex_exception
     */
    public function showvalue(string $name, string $label = '', array $attributes = []): ShowValue {
        $value = new ShowValue($name, $label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a empty validation field
     *
     * @param string $label
     * @param array $attributes
     * @return EmptyValidate
     * @throws \rex_exception
     */
    public function validateEmpty(string $label = '', array $attributes = []): EmptyValidate {
        $value = new EmptyValidate($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a compare validation field
     *
     * @param string $label
     * @param array $attributes
     * @return Compare
     * @throws \rex_exception
     */
    public function validateCompare(string $label = '', array $attributes = []): Compare {
        $value = new Compare($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a compare value validation field
     *
     * @param string $label
     * @param array $attributes
     * @return CompareValue
     * @throws \rex_exception
     */
    public function validateCompareValue(string $label = '', array $attributes = []): CompareValue {
        $value = new CompareValue($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a type validation field
     *
     * @param string $label
     * @param array $attributes
     * @return Type
     * @throws \rex_exception
     */
    public function validateType(string $label = '', array $attributes = []): Type {
        $value = new Type($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a int from to validation field
     *
     * @param string $label
     * @param array $attributes
     * @return IntFromTo
     * @throws \rex_exception
     */
    public function validateIntFromTo(string $label = '', array $attributes = []): IntFromTo {
        $value = new IntFromTo($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a password policy validation field
     *
     * @param string $label
     * @param array $attributes
     * @return PasswordPolicy
     * @throws \rex_exception
     */
    public function validatePasswordPolicy(string $label = '', array $attributes = []): PasswordPolicy {
        $value = new PasswordPolicy($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a preg match validation field
     *
     * @param string $label
     * @param array $attributes
     * @return PregMatch
     * @throws \rex_exception
     */
    public function validatePregMatch(string $label = '', array $attributes = []): PregMatch {
        $value = new PregMatch($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a size validation field
     *
     * @param string $label
     * @param array $attributes
     * @return Size
     * @throws \rex_exception
     */
    public function validateSize(string $label = '', array $attributes = []): Size {
        $value = new Size($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a preg match validation field
     *
     * @param string $label
     * @param array $attributes
     * @return SizeRange
     * @throws \rex_exception
     */
    public function validateSizeRange(string $label = '', array $attributes = []): SizeRange {
        $value = new SizeRange($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * create a preg match validation field
     *
     * @param string $label
     * @param array $attributes
     * @return Unique
     * @throws \rex_exception
     */
    public function validateUnique(string $label = '', array $attributes = []): Unique {
        $value = new Unique($label, $attributes);
        $this->addAttributes($value->attributes);
        return $value;
    }

    /**
     * @param array $attributes
     * @return void
     */
    private function addAttributes(array $attributes) {
        $this->fieldAttributes[] = $attributes;
    }
}