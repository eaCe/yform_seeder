<?php

namespace YformSeeder\Value;

use YformSeeder\Utilities;

class Html extends Value
{
    /** @var array|string[]  */
    private array $fieldAttributes = [
        'type_id' => 'value',
        'type_name' => 'html',
        'db_type' => 'none',
    ];

    /** @var array|string[]  */
    private array $allowedTypes = [
        'none',
    ];

    /**
     * create value field
     * @return void
     * @throws \rex_exception
     */
    protected function createValueField(): void {
        $this->attributes = array_merge($this->fieldAttributes, $this->attributes);

        if(!in_array($this->attributes['db_type'], $this->allowedTypes, true)) {
            $this->throwTypeNotSupportedException($this->attributes['db_type']);
        }
    }

    /**
     * set html value
     * @param string $html
     * @return void
     */
    public function set(string $html): void {
        $this->attributes['html'] = Utilities::sanitizeHtml($html);
    }
}