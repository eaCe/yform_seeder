
<?php
$form = new rex_fragment();
$fragment = new rex_fragment();
$fragment->setVar('class', 'info');
$fragment->setVar('body', $form->parse('yform_seeder/seeder.php'), false);
$content = $fragment->parse('core/page/section.php');
echo $content;
