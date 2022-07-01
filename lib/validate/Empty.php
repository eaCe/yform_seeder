<?php

namespace YformSeeder\Validate;

/**
 * Empty seems to be reserved...
 */
class EmptyValidate extends Validate
{
    /** @var array|string[]  */
    private array $fieldAttributes = [
        'type_id' => 'validate',
        'type_name' => 'empty',
        'db_type' => '',
        'not_required' => '',
        'message' => '',
        'type' => 'int',
    ];

    /** @var array|string[]  */
    private array $allowedTypes = [
        '',
    ];

    /** @var array|string[]  */
    private array $allowedValidationTypes = [
        'int',
        'float',
        'numeric',
        'string',
        'email',
        'url',
        'time',
        'datetime',
        'hex',
        'iban',
        'json',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValidationField(): void {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!in_array($this->attributes['type'], $this->allowedValidationTypes, true)) {
            $this->throwGenericNotSupportedException($this->attributes['type'], 'type');
        }

        if(!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}