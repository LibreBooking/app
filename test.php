<?php
require_once('lib/Common/namespace.php');
$lang = 'en_US';

load_language_file($lang);

$smarty = new SmartyPage();
$smarty->display('test.tpl');
?>