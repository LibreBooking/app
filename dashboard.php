<?php
define('ROOT_DIR', './');
require_once(ROOT_DIR . 'Pages/ControlPanelPage.php');

$page = new ControlPanelPage();
$page->PageLoad();

?>