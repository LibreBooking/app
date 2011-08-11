<?php
define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/MyCalendarPage.php');

$page = new PersonalCalendarPage();
$page->PageLoad();

?>