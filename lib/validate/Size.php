<?php

namespace YformSeeder\Validate;

use rex_exception;

use function in_array;

/**
 * Empty seems to be reserved...
 */
class Size extends Validate
{
    /** @var array|string[] */
    private array $fieldAttributes = [
        'type_id' => 'validate',
        'type_name' => 'size',
        'db_type' => '',
        'message' => '',
        'name' => '',
        'pattern' => '',
    ];

    /** @var array|string[] */
    private array $allowedTypes = [
        '',
    ];

    /**
     * create value field.
     * @throws rex_exception
     */
    protected function createValidationField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if (!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
