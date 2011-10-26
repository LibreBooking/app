<?php
define('ROOT_DIR', '../');

require_once(ROOT_DIR . '/Pages/ViewSchedulePage.php');

$page = new ViewSchedulePage();
$page->PageLoad();

?>