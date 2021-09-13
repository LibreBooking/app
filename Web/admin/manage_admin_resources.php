<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ResourceAdminManageResourcesPage.php');

$page = new RoleRestrictedPageDecorator(new ResourceAdminManageResourcesPage(), [RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN]);
$page->PageLoad();
