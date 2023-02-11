<?php

namespace YformSeeder\Value;

use rex_exception;

use function in_array;

class Checkbox extends Value
{
    /** @var array|string[] */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'checkbox',
        'db_type' => 'tinyint(1)',
    ];

    /** @var array|string[] */
    private array $allowedTypes = [
        'tinyint(1)',
    ];

    /**
     * create value field.
     * @throws rex_exception
     */
    protected function createValueField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if (!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
