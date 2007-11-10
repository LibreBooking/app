<?php
require_once('Pages/LoginPage.php');
require_once('Presenters/LoginPresenter.php');

$page = new LoginPage();

if ($page->LoggingIn())
{
	$page->Login();
}

$page->PageLoad();

?>