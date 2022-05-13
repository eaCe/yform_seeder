<?php

namespace YformSeeder\Value;

class BeMedia extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'be_media',
        'db_type' => 'text',
        'multiple' => 0,
        'types' => '*',
        'category' => '',
        'preview' => 0,
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