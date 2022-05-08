# :construction: WIP YForm Datenbank "Migration"/Seeder

Über die Addon-Einstellung lassen sich Templates mit einem Tabellen Namen für YForm Tabellen erstellen.
Über diese Templates lassen sich YForm-Tabllen, deren Felder und Demo-Daten anlegen.

Demo-Daten können auch mit [FakerPHP](https://fakerphp.github.io/) erstellt werden (im Addon enthalten).

Das Addon sollte nützlich sein, wenn man schnell einen YForm-Datensatz benötigt.

Die Templates werden im Data-Ordner des Addons erstellt und können dort angepasst werden. Danach können diese über die Einstellungen importiert werden.

---

**TODO**

- [ ] Erstellen von Values über Factory

---

**Beispiel Template:**

```php
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
use YformSeeder\Value\BeUser;
use YformSeeder\Value\Upload;
use YformSeeder\Value\IP;

$tableName = 'rex_blubb';

/** create table */
/** $tableName, $label/$name, $tableAttributes = [] */

Table::create($tableName, 'Meine Demo Tabelle');


/** create value fields */
/** $tableName, $name, $label, $attributes = [] */

Text::create($tableName, 'name', 'Name');
Integer::create($tableName, 'count', 'Anzahl');
TextArea::create($tableName, 'text', 'Freitext');


/** create a faker instance */
$faker = Faker\Factory::create();

/** register BeMedia provider if needed */
//$faker->addProvider(new \YformSeeder\Faker\BeMedia($faker));

/**
 * to get a random image name from the media pool use:
 * $faker->beMedia(int $categoryId = null, string $type = 'image/jpeg')
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
