<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/LogoutPage.php');

$page = new LogoutPage();

$page->PageLoad();
