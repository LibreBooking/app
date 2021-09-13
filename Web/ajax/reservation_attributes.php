<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationAttributesPage.php');

$page = new ReservationAttributesPage();
$page->PageLoad();
