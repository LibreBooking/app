<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/CalendarPage.php');

$page = new CalendarPage();

$page->PageLoad();

?>