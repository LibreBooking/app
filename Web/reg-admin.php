<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/RegistrationAdminPage.php');

$page = new RegistrationAdminPage();

$page->PageLoad();

?>