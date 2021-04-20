<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageResourcesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageResourcesPresenter.php');

$page = new AdminPageDecorator(new ManageResourcesPage());
$page->PageLoad();
