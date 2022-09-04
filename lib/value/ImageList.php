<?php

namespace YformSeeder\Value;

class ImageList extends Value
{
    /** @var array|string[]  */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'imagelist',
        'db_type' => 'text',
    ];

    /** @var array|string[]  */
    private array $allowedTypes = [
        'text',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValueField(): void
    {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if (!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}
