<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/Credits/UserCreditsPage.php');

$page = new SecurePageDecorator(new UserCreditsPage());
$page->PageLoad();
