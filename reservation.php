<?php 
define('ROOT_DIR', './');

require_once(ROOT_DIR . '/Pages/ReservationPage.php');

$page = new ReservationPage();
$page->PageLoad();
?>