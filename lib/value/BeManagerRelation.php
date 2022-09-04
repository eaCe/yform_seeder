<?php

namespace YformSeeder\Value;

class BeManagerRelation extends Value
{
    /** @var array|string[]  */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'be_manager_relation',
        'db_type' => 'text',
        'table' => '',
        'field' => '',
        'type' => '0',
        'empty_option' => '0',
    ];

    /** @var array|string[]  */
    private array $allowedTypes = [
        'text',
        'varchar(191)',
        'int',
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
