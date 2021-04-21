<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/Import/QuartzyImportPage.php');

$page = new AdminPageDecorator(new QuartzyImportPage());
$page->PageLoad();
