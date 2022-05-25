<?php

namespace YformSeeder\Value;

class Prio extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'prio',
        'db_type' => 'int',
        'scope' => '',
        'fields' => '',
    ];

    private array $allowedTypes = [
        'int',
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