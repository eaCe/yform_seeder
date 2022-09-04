<?php

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use YformSeeder\Table;
use YformSeeder\Seeder;
use YformSeeder\Utilities;

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

    /**
     * @return void
     */
    public function testNormalizeUtility(): void
    {
        $string = Utilities::normalize(123456789);

        self::assertIsString($string);
    }

    /**
     * @return void
     */
    public function testDoNotCreateFileUtility(): void
    {
        // disable/hide echo
        $this->setOutputCallback(static function () {});
        $file = Utilities::createFile('');

        self::assertFalse($file);
    }

    /**
     * @return void
     */
    public function testFileExistsCreateFileUtility(): void
    {
        // disable/hide echo
        $this->setOutputCallback(static function () {});
        Utilities::createFile('empty_unittest');
        $file = Utilities::createFile('empty_unittest');

        self::assertFalse($file);
    }

    public function tearDown(): void
    {
    }
}
