<?php

namespace YformSeeder\Validate;

use YformSeeder\Utilities;

class Validate
{
    public array $attributes = [
        'list_hidden' => 1,
        'search' => 0,
        'table_name' => '',
    ];

    /**
     * @param string $label
     * @param array $attributes
     * @throws \rex_exception
     */
    public function __construct(string $label = '', array $attributes = []) {
        $this->attributes['label'] = Utilities::sanitize($label);
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->createValidationField();
    }

    /**
     * create validation field
     * @return void
     * @throws \rex_exception
     */
    protected function createValidationField(): void {}

    /**
     * @throws \rex_exception
     */
    public function throwTypeNotSupportedException(string $type = ''): void {
        throw new \rex_exception('db_type ' . $type . ' not supported for ' . $this->attributes['name']);
    }

    /**
     * @throws \rex_exception
     */
    public function throwGenericNotSupportedException(string $type, string $attributeName): void {
        throw new \rex_exception($type . ' not supported for ' . $attributeName);
    }

    /**
     * @throws \rex_exception
     */
    public function throwRequiredException(string $attributeName): void {
        throw new \rex_exception($attributeName . ' is required!');
    }
}