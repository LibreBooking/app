<?php
define('ROOT_DIR', './');
require_once(ROOT_DIR . 'Pages/RegistrationMiniPage.php');

$page = new RegistrationMiniPage();

$page->PageLoad();

?>