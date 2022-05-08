<?php

namespace YformSeeder\Value;

class Choice extends Value
{
    private static array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'choice',
        'db_type' => 'text',
    ];

    private static array $allowedTypes = [
        'text',
        'int',
        'tinyint(1)',
        'varchar(191)',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    public static function createValueField(): void {
        $attributes = array_merge(self::$fieldAttributes, self::$attributes);

        if(!in_array($attributes['db_type'], self::$allowedTypes, true)) {
            self::throwTypeNotSupportedException($attributes['db_type']);
        }

        self::insert($attributes);
    }
}