<?php

$addon = rex_addon::get('yform_seeder');

if (\rex::isBackend()) {
    require_once 'lib/vendor/autoload.php';
}

if (rex::isBackend() &&
    ('index.php?page=yform_seeder/gui_table' === rex_url::currentBackendPage() ||
        'index.php?page=yform_seeder/gui_seeder' === rex_url::currentBackendPage())) {
    rex_view::addJsFile($addon->getAssetsUrl('yform-seeder.js'));
    rex_view::addCssFile($addon->getAssetsUrl('yform-seeder.css'));
    rex_view::setJsProperty('yform_seeder_url',
        rex_url::backendController([
            'rex-api-call' => 'yform_seeder',
            '_csrf_token' => rex_csrf_token::factory('rex_api_yform_seeder')->getValue(),
        ], false));
}
