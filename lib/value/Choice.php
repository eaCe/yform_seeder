<?php

namespace YformSeeder\Value;

class Choice extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'choice',
        'db_type' => 'text',
    ];

    private array $allowedTypes = [
        'text',
        'int',
        'tinyint(1)',
        'varchar(191)',
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