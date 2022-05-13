<?php

namespace YformSeeder\Value;

class Time extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'time',
        'db_type' => 'time',
        'format' => 'H:i:s',
        'widget' => 'input:text',
        'no_db' => 0,
        'current_time' => 0,
    ];

    private array $allowedTypes = [
        'time',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    public function createValueField(): void {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}