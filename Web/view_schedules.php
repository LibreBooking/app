<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/ScheduleViewerViewSchedulesPage.php');

$page = new ScheduleViewerViewSchedulesPage(new SmartyPage());
$page->PageLoad();