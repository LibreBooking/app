<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageQuotasPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');

$page = new AdminPageDecorator(new ManageQuotasPage());
$page->PageLoad();
