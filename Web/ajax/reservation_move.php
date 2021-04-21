<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationMovePage.php');

$page = new ReservationMovePage();
$page->PageLoad();
