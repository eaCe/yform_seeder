<?php

namespace YformSeeder\Value;

use rex_exception;

class Number extends Value
{
    /** @var array|string[] */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'number',
        'db_type' => 'DECIMAL(10,2)',
    ];

    /**
     * create value field.
     * @throws rex_exception
     */
    public function createValueField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if (!preg_match('/^((DECIMAL)(\((\d+),(\d+)\)))/', $this->attributes['db_type'])) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
