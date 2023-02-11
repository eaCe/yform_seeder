<?php

namespace YformSeeder\Value;

use rex_exception;

use function in_array;

class Prio extends Value
{
    /** @var array|string[] */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'prio',
        'db_type' => 'int',
        'scope' => '',
        'fields' => '',
    ];

    /** @var array|string[] */
    private array $allowedTypes = [
        'int',
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
