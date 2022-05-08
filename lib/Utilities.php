<?php

namespace YformSeeder;

class Utilities
{
    /**
     * @param string $path
     * @return void
     */
    public static function migrate(string $path): void {
        foreach (glob($path) as $file) {
            include_once $file;
        }
    }

    /**
     * normalize the given string
     * @param string $string
     * @return string
     */
    public static function normalize(string $string): string {
        return \rex_string::normalize($string);
    }

    /**
     * sanitize the given string
     * @param string $string
     * @return string
     */
    public static function sanitize(string $string): string {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

    private static function getAddon() {
        return \rex_addon::get('yform_seeder');
    }

    /**
     * check if the file already exists
     * @param string $tableName
     * @return bool
     */
    private static function fileExists(string $tableName): bool {
        $addon = self::getAddon();

        foreach (glob($addon->getDataPath() . '*.php') as $filePath) {
            $name  = basename($filePath);
            $nameParts = explode('_', $name);
            $name = str_replace([$nameParts[0] . '_', '.php'], ['', ''], $name);

            if($tableName === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * sanitize the given string
     * @param string $name
     * @return void
     */
    public static function createFile(string $name): void {
        $addon = self::getAddon();
        $tableName = \rex::getTable(self::normalize(self::sanitize($name)));
        $fileName = time() . '_' . $tableName . '.php';
        $filePath = $addon->getDataPath($fileName);
        $templateFileContents = \rex_file::get($addon->getPath('data/template.php'));
        $templateFileContents = str_replace('###tablename###', $tableName, $templateFileContents);

        if('' === $name) {
            echo \rex_view::error($addon->i18n('table_name_empty'));
            return;
        }

        if(self::fileExists($tableName)) {
            echo \rex_view::error($addon->i18n('table_name_exists', $tableName));
            return;
        }

        /** create dir if not available */
        \rex_dir::create($addon->getDataPath());

        /** create file from template */
        \rex_file::put($filePath, $templateFileContents);

        echo \rex_view::success($addon->i18n('template_created', $filePath));
    }

    /**
     * import templates
     * @return void
     */
    public static function importTemplates(): void {
        $addon = self::getAddon();
        foreach (glob($addon->getDataPath() . '*.php') as $filePath) {
            //TODO: check if already imported
            include_once $filePath;
        }
    }
}