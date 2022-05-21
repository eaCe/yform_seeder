<?php

namespace YformSeeder\Value;

class DateTime extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'datetime',
        'db_type' => 'datetime',
        'format' => 'Y-m-d H:i:s',
        'widget' => 'select',
        'year_start' => '',
        'year_end' => '',
    ];

    private array $allowedTypes = [
        'datetime',
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