<?php

use YformSeeder\Table;

/** available value types */
use YformSeeder\Value\BeMedia;
use YformSeeder\Value\Choice;
use YformSeeder\Value\Date;
use YformSeeder\Value\Datestamp;
use YformSeeder\Value\Time;
use YformSeeder\Value\Email;
use YformSeeder\Value\Integer;
use YformSeeder\Value\Number;
use YformSeeder\Value\Text;
use YformSeeder\Value\TextArea;
use YformSeeder\Value\Uuid;
use YformSeeder\Value\BeTable;
use YformSeeder\Value\BeUser;
use YformSeeder\Value\Upload;
use YformSeeder\Value\IP;

$tableName = '###tablename###';

/** create table */
/** $tableName, $label/$name, $tableAttributes = [] */

//Table::create($tableName, 'Label');


/** create value fields */
/** $tableName, $name, $label, $attributes = [] */

//Text::create($tableName, 'field_name', 'Field Name');


/** create a faker instance */
//$faker = Faker\Factory::create();

/** register REDAXO provider if needed */
//$faker->addProvider(new \YformSeeder\Faker\Redaxo($faker));

/**
 * to get a random image name from the media pool use:
 * $faker->beMedia(int $categoryId = null, string $type = 'image/jpeg')
 */

/**
 * to get a random article ID use:
 * $faker->beLink()
 */

/** add values */

//$sql = rex_sql::factory();
//$sql->setTable($tableName);