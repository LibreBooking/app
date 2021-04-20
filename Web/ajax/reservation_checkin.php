<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationCheckinPage.php');

$page = new ReservationCheckinPage();
$page->PageLoad();
