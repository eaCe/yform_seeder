# YForm Datenbank "Migration"/Seeder

Über die Addon-Einstellung lassen sich Templates mit einem Tabellen Namen für YForm Tabellen erstellen.
Über diese Templates lassen sich YForm-Tabllen, deren Felder und Demo-Daten anlegen.

Demo-Daten können auch mit [FakerPHP](https://fakerphp.github.io/) erstellt werden (im Addon enthalten).
Für Datum und Uhrzeit kann [Carbon](https://github.com/briannesbitt/carbon) genutzt werden.

Das Addon sollte nützlich sein, wenn man schnell einen YForm-Datensatz benötigt.

Die Templates werden im Data-Ordner des Addons erstellt und können dort angepasst werden. Danach können diese über die Einstellungen importiert werden.

---

**Beispiel Template:**

```php
use Carbon\Carbon;
use YformSeeder\Table;
use YformSeeder\Seeder;

/**
    available value types:
    ($name, $label, $attributes = [])
    ---
    $seeder->beLink('name', 'Name');
    $seeder->beManagerRelation('name', 'Name');
    $seeder->beMedia('name', 'Name');
    $seeder->beTable('name', 'Name');
    $seeder->beUser('name', 'Name');
    $seeder->checkbox('name', 'Name');
    $seeder->choice('name', 'Name');
    $seeder->date('name', 'Name');
    $seeder->datestamp('name', 'Name');
    $seeder->dateTime('name', 'Name');
    $seeder->email('name', 'Name');
    $seeder->imagelist('name', 'Name');
    $seeder->integer('name', 'Name');
    $seeder->ip('name', 'Name');
    $seeder->number('name', 'Name');
    $seeder->prio('name', 'Name');
    $seeder->showvalue('name', 'Name');
    $seeder->text('name', 'Name');
    $seeder->textarea('name', 'Name');
    $seeder->time('name', 'Name');
    $seeder->upload('name', 'Name');
    $seeder->uuid('name', 'Name');
*/

/**
    available validate types:
    ($label, $attributes = [])
    ---
    $seeder->validateCompare('Name');
    $seeder->validateCompareValue('Name');
    $seeder->validateEmpty('Name');
    $seeder->validateIntFromTo('Name');
    $seeder->validatePasswordPolicy('Name');
    $seeder->validatePregMatch('Name');
    $seeder->validateSize('Name');
    $seeder->validateSizeRange('Name');
    $seeder->validateType('Name');
    $seeder->validateUnique('Name');
*/

$tableName = 'rex_blubb';
$tableLabel = 'Meine Demo Tabelle';

/** create table */
/** $tableName, $label/$name, $tableAttributes = [] */

Table::create($tableName, $tableLabel);


/** create value factory */
/** $tableName */

$seeder = Seeder::factory($tableName);

/** prepare values */
/** $name, $label, $additionalAttributes = [] */

$seeder->text('name', 'Name');
$seeder->integer('count', 'Anzahl');
$seeder->textarea('text', 'Freitext');

/** create values */

$seeder->create();


/** create a faker instance */
$faker = Faker\Factory::create();

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
//mehrere Datensätze einfügen
for ($i = 0; $i < 10; $i++) {
    $sql = rex_sql::factory();
    $sql->setTable($tableName);

    $sql->setValue('name', $faker->name());
    $sql->setValue('count', $faker->randomNumber(2, false));
    $sql->setValue('text', $faker->text(100));

    $sql->insert();
}
```

---

**Ergebnis**

![table](https://user-images.githubusercontent.com/2708231/167286105-d3c6319b-3101-46d5-a7bf-73a0ed7b09e1.png)

![yform_table](https://user-images.githubusercontent.com/2708231/167286785-28a7d915-edb5-4aa7-a87d-fc6e8fba8a28.png)
