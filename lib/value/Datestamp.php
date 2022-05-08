<?php

namespace YformSeeder\Value;

class Datestamp extends Value
{
    private static array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'datestamp',
        'db_type' => 'datetime',
        'format' => 'Y-m-d H:i:s',
        'only_empty' => 0,
        'no_db' => 0,
    ];

    private static array $allowedTypes = [
        'datetime',
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