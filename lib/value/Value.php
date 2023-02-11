<?php

namespace YformSeeder\Value;

use rex_exception;
use YformSeeder\Utilities;

class Value
{
    public array $attributes = [
        'list_hidden' => 1,
        'search' => 0,
        'table_name' => '',
    ];

    /**
     * @throws rex_exception
     */
    public function __construct(string $name, string $label = '', array $attributes = [])
    {
        $this->attributes['name'] = Utilities::normalize(Utilities::sanitize($name));
        $this->attributes['label'] = Utilities::sanitize($label);
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->createValueField();
    }

    /**
     * create value field.
     * @throws rex_exception
     */
    protected function createValueField(): void
    {
    }

    /**
     * show field in list.
     */
    public function showInList(): void
    {
        $this->attributes['list_hidden'] = 0;
    }

    /**
     * show field in search.
     */
    public function showInSearch(): void
    {
        $this->attributes['search'] = 1;
    }

    /**
     * @throws rex_exception
     */
    public function throwTypeNotSupportedException(string $type = ''): void
    {
        throw new rex_exception('db_type ' . $type . ' not supported for ' . $this->attributes['name']);
    }

    /**
     * @throws rex_exception
     */
    public function throwGenericNotSupportedException(string $type, string $attributeName): void
    {
        throw new rex_exception($type . ' not supported for ' . $attributeName);
    }

    /**
     * @throws rex_exception
     */
    public function throwRequiredException(string $attributeName): void
    {
        throw new rex_exception($attributeName . ' is required!');
    }
}
