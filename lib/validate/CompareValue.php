<?php

namespace YformSeeder\Validate;

use rex_exception;

use function in_array;

/**
 * Empty seems to be reserved...
 */
class CompareValue extends Validate
{
    /** @var array|string[] */
    private array $fieldAttributes = [
        'type_id' => 'validate',
        'type_name' => 'compare_value',
        'compare_type' => '!=',
        'message' => '',
        'compare_value' => '',
        'name' => '',
    ];

    /** @var array|string[] */
    private array $allowedTypes = [
        '',
    ];

    /** @var array|string[] */
    private array $allowedCompareTypes = [
        '!=',
        '<',
        '>',
        '==',
        '>=',
        '<=',
    ];

    /**
     * create value field.
     * @throws rex_exception
     */
    protected function createValidationField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if ('' === $this->attributes['name']) {
            $this->throwRequiredException('name');
        }

        if (!in_array($this->attributes['compare_type'], $this->allowedCompareTypes, true)) {
            $this->throwGenericNotSupportedException($this->attributes['compare_type'], 'compare_type');
        }

        if (!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
