<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/ProfilePage.php');

$page = new SecureActionPageDecorator(new ProfilePage());
$page->PageLoad();
