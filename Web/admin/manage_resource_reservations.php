<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ResourceAdminManageReservationsPage.php');

$page = new RoleRestrictedPageDecorator(new ResourceAdminManageReservationsPage(), [RoleLevel::RESOURCE_ADMIN]);
$page->PageLoad();
