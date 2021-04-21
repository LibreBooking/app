<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/NotificationPreferencesPage.php');

$page = new NotificationPreferencesPage();
$page->PageLoad();
