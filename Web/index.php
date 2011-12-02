<?php

/**
 * Start page of application
 */
define('ROOT_DIR', '../');  // ROOT_DIR defined as string '../' (back one directory)
/**
 * Include LoginPage class and LoginPresenter class
 */
require_once(ROOT_DIR . 'Pages/LoginPage.php');
require_once(ROOT_DIR . 'Presenters/LoginPresenter.php');
/**
 * Initialization of object of class LoginPage()
 */
$page = new LoginPage();
/**
 * If Logging-In Page is requested or TRUE
 */
if ($page->LoggingIn()) {
    $page->Login(); // Preparing Logging-In Page components
}
/**
 * Now load page components to login.tpl page to be displayed
 * @var nill
 * @param nill
 */
$page->PageLoad();

?>