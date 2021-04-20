<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationAttributesPrintPage.php');

$page = new ReservationAttributesPrintPage();
$page->PageLoad();
