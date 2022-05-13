<?php

namespace YformSeeder\Value;

class Text extends Value
{
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'text',
        'db_type' => 'varchar(191)',
    ];

    private array $allowedTypes = [
        'varchar(191)',
        'text',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValueField(): void {
        echo '<pre>';
        var_dump("test2");
        echo '</pre>';
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }
}