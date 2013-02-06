<?php

/**
Part of phpScheduleIt
written by Stephen Oliver
add this file to /Web/admin/
 */

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageRemindersPage.php');

$page = new AdminPageDecorator(new ManageRemindersPage());
$page->PageLoad();
?>