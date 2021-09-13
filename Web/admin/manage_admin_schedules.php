<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ScheduleAdminManageSchedulesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');

$page = new RoleRestrictedPageDecorator(new ScheduleAdminManageSchedulesPage(), [RoleLevel::SCHEDULE_ADMIN]);
$page->PageLoad();
