<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Reservation/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/Reservation/ExistingReservationPage.php');

$server = ServiceLocator::GetServer();

if (!is_null($server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER))) {
    $page = new SecurePageDecorator(new ExistingReservationPage());
} elseif (!is_null($server->GetQuerystring(QueryStringKeys::SOURCE_REFERENCE_NUMBER))) {
    $page = new SecurePageDecorator(new DuplicateReservationPage());
} else {
    $page = new SecurePageDecorator(new NewReservationPage());
}

$page->PageLoad();
