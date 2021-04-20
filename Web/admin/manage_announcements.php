<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageAnnouncementsPage.php');

$page = new RoleRestrictedPageDecorator(new ManageAnnouncementsPage(), RoleLevel::All());
$page->PageLoad();
