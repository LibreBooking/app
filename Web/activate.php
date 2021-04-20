<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/ActivationPage.php');

$page = new ActivationPage();
$page->PageLoad();
