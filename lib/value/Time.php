<?php

namespace YformSeeder\Value;

use rex_exception;

use function in_array;

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

    /** @var array|string[] */
    private array $allowedTypes = [
        'time',
    ];

    /**
     * create value field.
     * @throws rex_exception
     */
    public function createValueField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if (!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
