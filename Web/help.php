<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/HelpPage.php');

$page = new HelpPage();
$page->PageLoad();
