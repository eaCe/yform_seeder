<?php

namespace YformSeeder\Faker;

use Faker\Provider\Base;

class BeMedia extends Base
{
    /**
     * get a random image from the media pool
     * @param int|null $categoryId
     * @param string $type
     * @return string
     * @throws \rex_sql_exception
     */
    public function beMedia(int $categoryId = null, string $type = 'image/jpeg'): string {
        $queryParams = ['type' => $type];
        $sql = \rex_sql::factory();
        $query = 'SELECT `filename` FROM ' . \rex::getTable('media');
        $query .= ' WHERE `filetype` = :type';
        if($categoryId) {
            $query .= ' AND `category_id` = :category';
            $queryParams['category'] = $categoryId;
        }
        $query .= ' ORDER BY RAND() LIMIT 1';
        $sql->setQuery($query, $queryParams);

        return $sql->getValue('filename');
    }
}