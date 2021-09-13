<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageResourceStatusPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageResourceStatusPresenter.php');

$page = new RoleRestrictedPageDecorator(new ManageResourceStatusPage(), [RoleLevel::APPLICATION_ADMIN, RoleLevel::SCHEDULE_ADMIN, RoleLevel::RESOURCE_ADMIN]);
$page->PageLoad();
