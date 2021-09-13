<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/RegistrationPage.php');

$page = new RegistrationPage();

$page->PageLoad();
