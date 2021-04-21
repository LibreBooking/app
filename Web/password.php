<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/PasswordPage.php');

$page = new PasswordPage();
$page->PageLoad();
