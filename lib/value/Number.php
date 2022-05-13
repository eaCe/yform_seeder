<?php

namespace YformSeeder\Value;

class Number extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'number',
        'db_type' => 'DECIMAL(10,2)',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    public function createValueField(): void {
        $attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!preg_match('/^((DECIMAL)(\((\d+),(\d+)\)))/', $attributes['db_type'])) {
            $this->throwTypeNotSupportedException($attributes['db_type']);
        }
    }
}