<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Search/SearchReservationsPage.php');

$page = new SecurePageDecorator(new SearchReservationsPage());
$page->PageLoad();
