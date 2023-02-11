<?php

namespace YformSeeder;

use rex;
use rex_addon;
use rex_addon_interface;
use rex_dir;
use rex_file;
use rex_sql;
use rex_sql_exception;
use rex_string;
use rex_view;

use function count;

class Utilities
{
    public static function migrate(string $path): void
    {
        $filePath = glob($path);

        if (false !== $filePath) {
            foreach ($filePath as $file) {
                include_once $file;
            }
        }
    }

    /**
     * normalize the given string.
     */
    public static function normalize(string $string): string
    {
        return rex_string::normalize($string);
    }

    /**
     * sanitize the given string.
     */
    public static function sanitize(string $string): string
    {
        $filtered = htmlspecialchars($string);

        if (false === $filtered) {
            return '';
        }

        return $filtered;
    }

    /**
     * sanitize the given html.
     */
    public static function sanitizeHtml(string $string): string
    {
        return rex_string::sanitizeHtml($string);
    }

    private static function getAddon(): rex_addon_interface
    {
        return rex_addon::get('yform_seeder');
    }

    /**
     * check if the file already exists.
     */
    private static function fileExists(string $tableName): bool
    {
        $addon = self::getAddon();
        $filePaths = glob($addon->getDataPath() . '*.php');

        if (false !== $filePaths) {
            foreach ($filePaths as $filePath) {
                $name = basename($filePath);
                $nameParts = explode('_', $name);
                $name = str_replace([$nameParts[0] . '_', '.php'], ['', ''], $name);

                if ($tableName === $name) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * sanitize the given string.
     * @return void|false
     */
    public static function createFile(string $name)
    {
        $addon = self::getAddon();
        $tableName = rex::getTable(self::normalize(self::sanitize($name)));
        $fileName = time() . '_' . $tableName . '.php';
        $filePath = $addon->getDataPath($fileName);
        $templateFileContents = rex_file::get($addon->getPath('data/template.php'));
        $templateFileContents = str_replace('###tablename###', $tableName, $templateFileContents);

        if ('' === $name) {
            echo rex_view::error($addon->i18n('table_name_empty'));
            return false;
        }

        if (self::fileExists($tableName)) {
            echo rex_view::error($addon->i18n('table_name_exists', $tableName));
            return false;
        }

        /** create dir if not available */
        rex_dir::create($addon->getDataPath());

        /** create file from template */
        rex_file::put($filePath, $templateFileContents);

        echo rex_view::success($addon->i18n('template_created', $filePath));
    }

    /**
     * import templates.
     * @throws rex_sql_exception
     * @return void|null
     */
    public static function importTemplates()
    {
        $addon = self::getAddon();
        $dataDir = $addon->getDataPath();

        if (!is_readable($dataDir)) {
            return null;
        }

        // 2 = empty -> ['.', '..']
        if (2 === count(scandir($dataDir))) {
            return null;
        }

        foreach (glob($addon->getDataPath() . '*.php') as $filePath) {
            $name = str_replace([$addon->getDataPath(), '.php'], ['', ''], $filePath);

            $sql = rex_sql::factory();
            $sql->setTable(rex::getTable($addon->getName()));
            $sql->setWhere('`file` = :name', ['name' => $name]);
            $sql->select();

            if (0 !== $sql->getRows()) {
                include_once $filePath;

                $sql = rex_sql::factory();
                $sql->setTable(rex::getTable($addon->getName()));
                $sql->setValue('file', $name);
                $sql->insert();
            }
        }
    }
}
