<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/Import/ICalImportPage.php');

$page = new AdminPageDecorator(new ICalImportPage());
$page->PageLoad();
