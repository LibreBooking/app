<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageGroupsPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');

$page = new AdminPageDecorator(new ManageGroupsPage());
$page->PageLoad();
