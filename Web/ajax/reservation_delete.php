<?php 
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationDeletePage.php');

$page = new ReservationDeletePage();
$page->PageLoad();
?>