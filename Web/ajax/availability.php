<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationUserAvailabilityPage.php');

$page = new SecurePageDecorator(new ReservationUserAvailabilityPage());
$page->PageLoad();
