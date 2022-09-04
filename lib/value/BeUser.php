<?php

namespace YformSeeder\Value;

class BeUser extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'be_user',
        'db_type' => 'varchar(191)',
        'only_empty' => 0,
        'show_value' => 0,
    ];

    /** @var array|string[]  */
    private array $allowedTypes = [
        'varchar(191)',
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
