<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ServerSettingsPage.php');

$page = new ServerSettingsPage();

$page->PageLoad();
