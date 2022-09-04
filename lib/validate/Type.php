<?php

namespace YformSeeder\Validate;

/**
 * Empty seems to be reserved...
 */
class Type extends Validate
{
    /** @var array|string[]  */
    private array $fieldAttributes = [
        'type_id' => 'validate',
        'type_name' => 'type',
        'db_type' => '',
        'message' => '',
    ];

    /** @var array|string[]  */
    private array $allowedTypes = [
        '',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValidationField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if (!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
