<?php
require_once('Pages/LoginPage.php');
require_once('Presenters/LoginPresenter.php');
require_once('lib/Server/namespace.php');

$page = new LoginPage(new Server());
$page->PageLoad();
?>