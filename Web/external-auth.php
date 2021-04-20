<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Authentication/ExternalAuthLoginPage.php');
require_once(ROOT_DIR . 'Presenters/Authentication/ExternalAuthLoginPresenter.php');

$page = new ExternalAuthLoginPage();
$page->PageLoad();
