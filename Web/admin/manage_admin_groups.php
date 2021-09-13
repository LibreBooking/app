<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/GroupAdminManageGroupsPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');

$page =  new RoleRestrictedPageDecorator(new GroupAdminManageGroupsPage(), [RoleLevel::GROUP_ADMIN]);
$page->PageLoad();
