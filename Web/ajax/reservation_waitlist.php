<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationWaitlistPage.php');

$page = new ReservationWaitlistPage();
$page->PageLoad();
