<?php

use YformSeeder\Table;
use YformSeeder\Seeder;

/**
    available value types:
    ---
    $seeder->beLink('name', 'Name');
    $seeder->beMedia('name', 'Name');
    $seeder->beTable('name', 'Name');
    $seeder->beUser('name', 'Name');
    $seeder->checkbox('name', 'Name');
    $seeder->choice('name', 'Name');
    $seeder->date('name', 'Name');
    $seeder->datestamp('name', 'Name');
    $seeder->email('name', 'Name');
    $seeder->imagelist('name', 'Name');
    $seeder->integer('name', 'Name');
    $seeder->ip('name', 'Name');
    $seeder->number('name', 'Name');
    $seeder->showvalue('name', 'Name');
    $seeder->text('name', 'Name');
    $seeder->textarea('name', 'Name');
    $seeder->time('name', 'Name');
    $seeder->upload('name', 'Name');
    $seeder->uuid('name', 'Name');
*/

$tableName = '###tablename###';
$tableLabel = '';

/** create table */
/** $tableName, $label/$name, $tableAttributes = [] */

//Table::create($tableName, $tableLabel);


/** create value factory */
/** $tableName */

//$seeder = Seeder::factory($tableName);

/** prepare values */
/** $name, $label, $additionalAttributes = [] */

//$seeder->textarea('field_name', 'Field Name');

/** create values */

//$seeder->create();


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