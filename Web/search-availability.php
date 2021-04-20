<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/SearchAvailabilityPage.php');

$page = new SecurePageDecorator(new SearchAvailabilityPage());
$page->PageLoad();
