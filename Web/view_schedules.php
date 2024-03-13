<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/ScheduleViewerViewSchedulesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');

$page = new ScheduleViewerViewSchedulesPage(new SmartyPage());
$page->PageLoad();