<?php
define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/OpeningsPage.php');

$page = new OpeningsPage();

$page->PageLoad();
?>
