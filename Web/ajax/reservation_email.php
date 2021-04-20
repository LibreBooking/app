<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Ajax/ReservationEmailPage.php');

$page = new ReservationEmailPage();
$page->PageLoad();
