<?php

namespace YformSeeder\Value;

class Datestamp extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'datestamp',
        'db_type' => 'datetime',
        'format' => 'Y-m-d H:i:s',
        'only_empty' => 0,
        'no_db' => 0,
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