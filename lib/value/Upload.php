<?php

namespace YformSeeder\Value;

class Upload extends Value
{
    private static array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'upload',
        'db_type' => 'text',
        'types' => '*',
        'required' => 0,
    ];

    private static array $allowedTypes = [
        'text',
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