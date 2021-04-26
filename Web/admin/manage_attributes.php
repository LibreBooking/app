<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageAttributesPage.php');

$page = new AdminPageDecorator(new ManageAttributesPage());
$page->PageLoad();
