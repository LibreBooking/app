<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageBlackoutsPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageBlackoutsPresenter.php');

$page = new RoleRestrictedPageDecorator(new ManageBlackoutsPage(), [RoleLevel::APPLICATION_ADMIN, RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN]);
$page->PageLoad();
