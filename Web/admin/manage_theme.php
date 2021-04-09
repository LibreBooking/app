<?php

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Pages/Admin/ManageThemePage.php');

$page = new AdminPageDecorator(new ManageThemePage());
$page->PageLoad();
