<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/DataCleanupPage.php');

$page = new DataCleanupPage();
$page->PageLoad();
