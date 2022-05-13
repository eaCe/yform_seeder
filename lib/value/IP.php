<?php

namespace YformSeeder\Value;

class IP extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'ip',
        'db_type' => 'varchar(191)',
        'no_db' => 0,
    ];

    private array $allowedTypes = [
        'text',
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