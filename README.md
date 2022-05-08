# :construction: WIP YForm Datenbank Migration/Seeder

Über die Addon-Einstellung lassen sich Templates mit einem Tabellen Namen für YForm Tabellen erstellen.
Über diese Templates lassen sich YForm-Tabllen, deren Felder und Demo-Daten anlegen.

Demo-Daten können auch mit [FakerPHP](https://fakerphp.github.io/) erstellt werden (im Addon enthalten).

Das Addon sollte nützlich sein, wenn man schnell einen YForm-Datensatz benötigt.

Die Templates werden im Data-Ordner des Addons erstellt und können dort angepasst werden. Danach können diese über die Einstellungen importiert werden.

---

**Beispiel Template:**

```php
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
