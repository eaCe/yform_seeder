<?php

namespace YformSeeder\Value;

class Number extends Value
{
    private static array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'number',
        'db_type' => 'DECIMAL(10,2)',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    public static function createValueField(): void {
        $attributes = array_merge(self::$fieldAttributes, self::$attributes);

        if(!preg_match('/^((DECIMAL)(\((\d+),(\d+)\)))/', $attributes['db_type'])) {
            self::throwTypeNotSupportedException($attributes['db_type']);
        }

        self::insert($attributes);
    }
}