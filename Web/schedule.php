<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/SchedulePage.php');

$page = new SecurePageDecorator(new SchedulePage());
$page->PageLoad();
