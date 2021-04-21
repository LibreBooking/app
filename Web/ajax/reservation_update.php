<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationUpdatePage.php');

$page = new ReservationUpdatePage();
$page->PageLoad();
