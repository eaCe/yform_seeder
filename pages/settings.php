<?php

/** @var rex_addon $this */

use YformSeeder\Utilities;

if (rex_post('create_template', 'bool')) {
    $tableName = '';

    if ('' !== rex_post('table_name')) {
        $tableName = rex_post('table_name', 'string');
    }

    Utilities::createFile($tableName);
}

if (rex_post('import_templates', 'bool')) {
    Utilities::importTemplates();
}

$content = '';

$formElements = [];

/**
 * misc.
 */
$inputGroups = [];
$n = [];
$n['before'] = '<label class="form-label form-group-header" for="table_name">' . $this->i18n('table_name') . '</label>';
$n['field'] = '<input class="form-control" type="text" value="" id="table_name" name="table_name"/>';
$n['field'] .= '<p class="help-block">' . $this->i18n('table_notice') . '</p>';
$inputGroups[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $inputGroups, false);
$content .= $fragment->parse('core/form/input_group.php');

$n = [];
$n['field'] = '<button class="btn btn-save" type="submit" name="create_template" value="1" ' . rex::getAccesskey($this->i18n('save'), 'save') . '>' . $this->i18n('create_template') . '</button>';
$formElements[] = $n;
$n = [];
$n['field'] = '&nbsp;<button class="btn btn-info" type="submit" name="import_templates" value="1">' . $this->i18n('import_templates') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('flush', true);
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('settings'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$content = $fragment->parse('core/page/section.php');

echo '
    <form action="' . rex_url::currentBackendPage() . '" method="post">
        ' . $content . '
    </form>';

/** get already imported templates */
$sql = rex_sql::factory();
$sql->setTable(rex::getTable($this->getName()));
$templatesQuery = $sql->select('file as file')->getArray();
$importedTemplates = array_map(static function ($template) {
    return $template['file'];
}, $templatesQuery);
$notImportedTemplates = [];
$filePaths = glob($this->getDataPath() . '*.php');

if (false !== $filePaths) {
    foreach ($filePaths as $filePath) {
        $name = str_replace([$this->getDataPath(), '.php'], ['', ''], $filePath);

        if (in_array($name, $importedTemplates, true)) {
            continue;
        }

        $notImportedTemplates[] = $name;
    }
}

$infoContent = '<div class="row">';
$infoContent .= '<div class="col-lg-6">';
if (0 !== count($importedTemplates)) {
    $infoContent .= '<table class="table table-striped">';
    $infoContent .= '<thead><tr><th>' . $this->i18n('imported_templates') . '</th></th></thead>';
    $infoContent .= '<tbody>';
    foreach ($importedTemplates as $template) {
        $infoContent .= '<tr><td>' . $template . '.php</td></tr>';
    }
    $infoContent .= '</tbody></table>';
}
$infoContent .= '</div>';
$infoContent .= '<div class="col-lg-6">';
if (0 !== count($notImportedTemplates)) {
    $infoContent .= '<table class="table table-striped">';
    $infoContent .= '<thead><tr><th>' . $this->i18n('yform_seeder_not_imported_templates') . '</th></th></thead>';
    $infoContent .= '<tbody>';
    foreach ($notImportedTemplates as $template) {
        $infoContent .= '<tr><td>' . $template . '.php</td></tr>';
    }
    $infoContent .= '</tbody></table>';
}
$infoContent .= '</div>';
$infoContent .= '</div>';

if (0 !== count($importedTemplates) || 0 !== count($notImportedTemplates)) {
    $fragment = new rex_fragment();
    $fragment->setVar('class', 'info');
    $fragment->setVar('body', $infoContent, false);
    $content = $fragment->parse('core/page/section.php');
    echo $content;
}
