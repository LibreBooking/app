<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Reservation/GuestReservationPage.php');

$page = new GuestReservationPage();
$page->PageLoad();
