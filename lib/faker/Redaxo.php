<?php

namespace YformSeeder\Faker;

use Faker\Provider\Base;
use rex;
use rex_sql;
use rex_sql_exception;

class Redaxo extends Base
{
    /**
     * get a random image from the media pool.
     * @throws rex_sql_exception
     */
    public function beMedia(int $categoryId = null, string $type = 'image/jpeg'): string
    {
        $queryParams = ['type' => $type];
        $sql = rex_sql::factory();
        $query = 'SELECT `filename` FROM ' . rex::getTable('media');
        $query .= ' WHERE `filetype` = :type';
        if (null !== $categoryId) {
            $query .= ' AND `category_id` = :category';
            $queryParams['category'] = $categoryId;
        }
        $query .= ' ORDER BY RAND() LIMIT 1';
        $sql->setQuery($query, $queryParams);

        return $sql->getValue('filename');
    }

    /**
     * get a random article id.
     * @throws rex_sql_exception
     */
    public function beLink(): string
    {
        $sql = rex_sql::factory();
        $query = 'SELECT `id` FROM ' . rex::getTable('article');
        $query .= ' WHERE `status` = 1';
        $query .= ' ORDER BY RAND() LIMIT 1';
        $sql->setQuery($query);

        return $sql->getValue('id');
    }
}
