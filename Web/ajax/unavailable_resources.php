<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/UnavailableResourcesPage.php');

$page = new SecurePageDecorator(new UnavailableResourcesPage());
$page->PageLoad();
