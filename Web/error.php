<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/ErrorPage.php');

$page = new ErrorPage();

$page->PageLoad();
