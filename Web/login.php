<?php
define('ROOT_DIR', './');

require_once(ROOT_DIR . 'Pages/LoginPage.php');
require_once(ROOT_DIR . 'Presenters/LoginPresenter.php');

$page = new LoginPage();

if ($page->LoggingIn())
{
	$page->Login();
}

$page->PageLoad();

?>