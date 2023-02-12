<div class="alert alert-danger">
    Achtung! Es handelt sich noch um eine Entwicklungsversion.
    <br>
    Nicht auf Produktivsystemen einsetzen, vorher am besten ein Datenbank-Backup erstellen.
</div>

<?php
$form = new rex_fragment();
$fragment = new rex_fragment();
$fragment->setVar('class', 'info');
$fragment->setVar('body', $form->parse('yform_seeder/form.php'), false);
$content = $fragment->parse('core/page/section.php');
echo $content;
