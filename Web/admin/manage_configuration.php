<?php

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Pages/Admin/ManageConfigurationPage.php');

$page = new AdminPageDecorator(new ManageConfigurationPage());
$page->PageLoad();
