<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/


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