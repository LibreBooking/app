<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AvailableAccessoriesPage.php');

$page = new SecurePageDecorator(new AvailableAccessoriesPage());
$page->PageLoad();
