<?php

namespace YformSeeder\Value;

class Date extends Value
{
    private static array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'date',
        'db_type' => 'date',
        'format' => 'Y-m-d',
    ];

    private static array $allowedTypes = [
        'date',
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