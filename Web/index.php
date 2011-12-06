<?php

/**
 * Start page of application.
 */
define('ROOT_DIR', '../');  // ROOT_DIR defined as string '../' (back one directory).
/**
 * Include LoginPage class and LoginPresenter class
 */
require_once(ROOT_DIR . 'Pages/LoginPage.php');
require_once(ROOT_DIR . 'Presenters/LoginPresenter.php');
/**
 * Initialization of object of class LoginPage().
 */
$page = new LoginPage();
/**
 * A login is attempted, response accordingly.
 */
if ($page->LoggingIn()) {   // Is form ['submit'] returned?
    
    $page->Login(); // Verify the login and reponse accordingly.
}
/**
 * Now load page components to login.tpl page to be displayed.
 * @var nill
 * @param nill
 */
$page->PageLoad();  // Loading the login page.

?>