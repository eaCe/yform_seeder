<?php

namespace YformSeeder\Value;

class Date extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'date',
        'db_type' => 'date',
        'format' => 'Y-m-d',
    ];

    private array $allowedTypes = [
        'date',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValueField(): void {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}