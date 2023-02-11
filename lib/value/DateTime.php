<?php

namespace YformSeeder\Value;

use rex_exception;

use function in_array;

class DateTime extends Value
{
    /** @var array|string[] */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'datetime',
        'db_type' => 'datetime',
        'format' => 'Y-m-d H:i:s',
        'widget' => 'select',
        'year_start' => '',
        'year_end' => '',
    ];

    /** @var array|string[] */
    private array $allowedTypes = [
        'datetime',
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
