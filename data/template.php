<?php

use YformSeeder\Table;

/** available value types */
use YformSeeder\Value\Choice;
use YformSeeder\Value\Date;
use YformSeeder\Value\Email;
use YformSeeder\Value\Integer;
use YformSeeder\Value\Number;
use YformSeeder\Value\Text;
use YformSeeder\Value\TextArea;
use YformSeeder\Value\Uuid;
use YformSeeder\Value\BeUser;

$tableName = '###tablename###';

/** create table */
/** $tableName, $label/$name, $tableAttributes = [] */

//Table::create($tableName, 'Label');


/** create value fields */
/** $tableName, $name, $label, $attributes = [] */

//Text::create($tableName, 'field_name', 'Field Name');


/** create a faker instance */
//$faker = Faker\Factory::create();

/** add values */

//$sql = rex_sql::factory();
//$sql->setTable($tableName);