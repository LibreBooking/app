<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/MonitorDisplayPage.php');

$page = new MonitorDisplayPage();
$page->PageLoad();
