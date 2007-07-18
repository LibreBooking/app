<?php
require_once('Pages/LoginPage.php');
require_once('Presenters/LoginPresenter.php');

$page = new LoginPage(new Server());

if ($page->LoggingIn())
{
	$page->Login();
}
else
{
	$page->PageLoad();
}
?>