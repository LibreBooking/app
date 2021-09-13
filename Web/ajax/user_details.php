<?php

define('ROOT_DIR', '../../');

require(ROOT_DIR . 'Pages/Ajax/UserDetailsPopupPage.php');

$page = new UserDetailsPopupPage();
$page->PageLoad();
