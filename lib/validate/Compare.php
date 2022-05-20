<?php

namespace YformSeeder\Validate;

/**
 * Empty seems to be reserved...
 */
class Compare extends Validate
{
    private array $fieldAttributes = [
        'type_id' => 'validate',
        'type_name' => 'compare',
        'compare_type' => '!=',
        'message' => '',
        'name' => '',
        'name2' => '',
    ];

    private array $allowedTypes = [
        '',
    ];

    private array $allowedCompareTypes = [
        '!=',
        '<',
        '>',
        '==',
        '>=',
        '<=',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValidationField(): void {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if($this->attributes['name'] === '') {
            $this->throwRequiredException('name');
        }

        if($this->attributes['name2'] === '') {
            $this->throwRequiredException('name2');
        }

        if(!in_array($this->attributes['compare_type'], $this->allowedCompareTypes, true)) {
            $this->throwGenericNotSupportedException($this->attributes['compare_type'], 'compare_type');
        }

        if(!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}