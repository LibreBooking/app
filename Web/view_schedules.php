<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Admin/ScheduleViewerViewSchedulesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');

$page = new RoleRestrictedPageDecorator(new ScheduleViewerViewSchedulesPage(), [RoleLevel::SCHEDULE_ADMIN]);
$page->PageLoad();