<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageAccessoriesPage.php');

$page = new AdminPageDecorator(new ManageAccessoriesPage());
$page->PageLoad();
