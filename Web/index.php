<?php

define('ROOT_DIR', '../');

if (!file_exists(ROOT_DIR . 'config/config.php')) {
    die('Missing config/config.php. Please refer to the installation instructions.');
}

require_once(ROOT_DIR . 'Pages/LoginPage.php');
require_once(ROOT_DIR . 'Presenters/LoginPresenter.php');

$page = new LoginPage();

if ($page->LoggingIn()) {
    $page->Login();
}

if ($page->ChangingLanguage()) {
    $page->ChangeLanguage();
}

$page->PageLoad();
