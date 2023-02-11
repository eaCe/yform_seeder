<?php

use PHPUnit\Framework\TestCase;
use YformSeeder\Seeder;
use YformSeeder\Utilities;

/**
 * @internal
 */
final class SeederTest extends TestCase
{
    protected static string $tableName;

    protected function setUp(): void
    {
        self::$tableName = 'rex_seeder_unittest';
    }

    protected function tearDown(): void
    {
    }

    /**
     * @throws rex_sql_exception
     */
    public function testEmptyTableName(): void
    {
        self::expectException(rex_exception::class);

        $seeder = Seeder::factory('');
        $seeder->create();
    }

    public function testNormalizeUtility(): void
    {
        $string = Utilities::normalize(123456789);

        static::assertIsString($string);
    }

    public function testDoNotCreateFileUtility(): void
    {
        // disable/hide echo
        $this->setOutputCallback(static function () {
        });
        $file = Utilities::createFile('');

        static::assertFalse($file);
    }

    public function testFileExistsCreateFileUtility(): void
    {
        // disable/hide echo
        $this->setOutputCallback(static function () {
        });
        Utilities::createFile('empty_unittest');
        $file = Utilities::createFile('empty_unittest');

        static::assertFalse($file);
    }
}
