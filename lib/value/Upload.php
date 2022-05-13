<?php

namespace YformSeeder\Value;

class Upload extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'upload',
        'db_type' => 'text',
        'types' => '*',
        'required' => 0,
    ];

    private array $allowedTypes = [
        'text',
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