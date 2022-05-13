<?php

namespace YformSeeder\Value;

class Integer extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'integer',
        'db_type' => 'int',
    ];

    private array $allowedTypes = [
        'int',
        'bigint',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValueField(): void {
        $attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!in_array($attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($attributes['db_type']);
        }
    }
}