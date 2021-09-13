<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/GroupAdminManageUsersPage.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

$page = new RoleRestrictedPageDecorator(new GroupAdminManageUsersPage(), [RoleLevel::GROUP_ADMIN]);
$page->PageLoad();
