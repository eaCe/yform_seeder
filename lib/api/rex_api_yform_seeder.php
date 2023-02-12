<?php

class rex_api_yform_seeder extends rex_api_function
{
    protected $published = false;

    /**
     * @throws rex_sql_exception
     * @throws rex_exception
     * @throws JsonException
     */
    public function execute(): void
    {
        if (!rex_csrf_token::factory('rex_api_yform_seeder')->isValid()) {
            rex_response::setStatus(rex_response::HTTP_FORBIDDEN);
            rex_response::sendContent('Forbidden');
            exit;
        }

        $create = rex_post('create', 'bool');

        if ($create) {
            $tableName = rex_post('table_name', 'string');
            $tableLabel = rex_post('table_label', 'string');
            $perPage = rex_post('per_page', 'int');
            $active = rex_post('active', 'bool');
            $fields = json_decode(rex_post('fields'), false);
            $data = [
                'table_name' => $tableName,
                'table_label' => $tableLabel,
                'per_page' => $perPage,
                'active' => $active,
                'fields' => $fields,
            ];

            try {
                \YformSeeder\GUI::createTable((object) $data);
            } catch (Exception $e) {
                rex_response::setStatus(rex_response::HTTP_INTERNAL_ERROR);
                rex_response::sendContent($e->getMessage());
                exit;
            }
        }

        exit;
    }
}
