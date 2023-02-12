<?php

namespace YformSeeder;

use JsonException;
use rex_autoload;

use rex_exception;

use rex_sql;
use rex_sql_exception;

use rex_yform_base_abstract;

use rex_yform_manager_table;

use function count;
use function in_array;

class GUI
{
    private static $blockList = [
    ];

    public static function getValuesArray(): array
    {
        return self::getTypeArray('rex_yform_value_');
    }

    public static function getValidatesArray(): array
    {
        return self::getTypeArray('rex_yform_validate_', 'validate_');
    }

    private static function getTypeArray(string $split, string $prefix = ''): array
    {
        $types = [];

        foreach (rex_autoload::getClasses() as $class) {
            $exploded = explode($split, $class);
            if (2 === count($exploded)) {
                $name = $exploded[1];
                if ('abstract' !== $name) {
                    /** @var rex_yform_base_abstract $class */
                    $class = new $class();
                    $definitions = $class->getDefinitions();

                    if (count($definitions) > 0) {
                        if (in_array($definitions['name'], self::$blockList, true)
                            || !self::methodExists($prefix . $definitions['name'])) {
                            continue;
                        }

                        $types[$definitions['name']] = $definitions;
                    }
                }
            }
        }

        usort($types, static function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        return $types;
    }

    private static function snakeToCamel(string $string): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    private static function methodExists(string $name): bool
    {
        return method_exists('YformSeeder\Seeder', self::snakeToCamel($name));
    }

    /**
     * @throws rex_exception
     * @throws rex_sql_exception
     * @throws JsonException
     */
    public static function createTable(object $data): void
    {
        $attributes = [];

        if (isset($data->per_page)) {
            $attributes['list_amount'] = (int) $data->per_page;
        }

        if (isset($data->list_hidden)) {
            $attributes['list_hidden'] = (int) $data->list_hidden;
        }

        if (!isset($data->table_name, $data->table_label) ||
            ('' === $data->table_name || '' === $data->table_label)) {
            throw new rex_exception('Table name or label missing');
        }

        $tableName = Utilities::normalize(Utilities::sanitize($data->table_name));

        if (rex_yform_manager_table::get($tableName)) {
            throw new rex_exception('Table already exists');
        }

        Table::create($tableName, $data->table_label, $attributes);

        $seeder = Seeder::factory($tableName);
        foreach ($data->fields as $field) {
            $prefix = '';

            if ('validate' === $field->type) {
                $prefix = 'validate_';
            }

            if (!self::methodExists($prefix . $field->field_name) ||
                '' === $field->field_name ||
                '' === $field->name ||
                '' === $field->label) {
                continue;
            }

            $seeder->{$prefix . $field->field_name}($field->name, $field->label, $attributes);
            $seeder->create();
        }
    }

    /**
     * @throws rex_sql_exception
     */
    public static function getTablesArray(): array
    {
        $sql = rex_sql::factory();
        $sql->setTable(rex_yform_manager_table::table());
        $sql->select('id, table_name, name');

        if ($sql->getRows()) {
            return $sql->getArray();
        }

        return [];
    }
}
