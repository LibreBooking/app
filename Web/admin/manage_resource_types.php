<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageResourceTypesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageResourceTypesPresenter.php');

$page = new RoleRestrictedPageDecorator(new ManageResourceTypesPage(), [RoleLevel::APPLICATION_ADMIN, RoleLevel::SCHEDULE_ADMIN, RoleLevel::RESOURCE_ADMIN]);
$page->PageLoad();
