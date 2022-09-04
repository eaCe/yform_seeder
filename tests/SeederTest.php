<?php

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use YformSeeder\Table;
use YformSeeder\Seeder;

final class SeederTest extends TestCase
{
    protected static string $tableName;

    /**
     * @return void
     */
    public function setUp(): void
    {
        self::$tableName = 'rex_seeder_unittest';
    }

    /**
     * @return void
     * @throws rex_sql_exception
     */
    public function testEmptyTableName(): void
    {
        self::expectException(rex_exception::class);

        $seeder = Seeder::factory('');
        $seeder->create();
    }

    public function tearDown(): void
    {
    }
}
