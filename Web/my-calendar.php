<?php
define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/PersonalCalendarPage.php');

$page = new PersonalCalendarPage();
$page->PageLoad();

?>