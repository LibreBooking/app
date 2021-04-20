<?php

define('ROOT_DIR', '../../');

require(ROOT_DIR . 'Pages/Ajax/ReservationPopupPage.php');

$page = new ReservationPopupPage();
$page->PageLoad();
