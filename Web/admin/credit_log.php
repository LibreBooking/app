<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/CreditLogPage.php');

$page = new RoleRestrictedPageDecorator(new CreditLogPage(), [RoleLevel::GROUP_ADMIN, RoleLevel::APPLICATION_ADMIN]);
$page->PageLoad();
