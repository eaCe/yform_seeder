<?php

namespace YformSeeder\Value;

class Email extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'email',
        'db_type' => 'varchar(191)',
    ];

    private array $allowedTypes = [
        'varchar(191)',
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