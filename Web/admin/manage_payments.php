<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManagePaymentsPage.php');

$page = new AdminPageDecorator(new ManagePaymentsPage());
$page->PageLoad();
