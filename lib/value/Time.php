<?php

namespace YformSeeder\Value;

class Time extends Value
{
    private static array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'time',
        'db_type' => 'time',
        'format' => 'H:i:s',
        'widget' => 'input:text',
        'no_db' => 0,
        'current_time' => 0,
    ];

    private static array $allowedTypes = [
        'time',
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