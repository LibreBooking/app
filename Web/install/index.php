<?php
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/InstallPage.php');

// create or recreate database?
// create database user?


$page = new InstallPage();
$page->PageLoad();



?>