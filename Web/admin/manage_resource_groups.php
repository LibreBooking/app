<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageResourceGroupsPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageResourceGroupsPresenter.php');

$page = new RoleRestrictedPageDecorator(new ManageResourceGroupsPage(), [RoleLevel::APPLICATION_ADMIN, RoleLevel::SCHEDULE_ADMIN, RoleLevel::RESOURCE_ADMIN]);
$page->PageLoad();
