<?php
interface IPage
{
	public function Redirect($url);
}

class Pages
{
	const DEFAULT_LOGIN = 'controlpanel.php';
	const LOGIN = 'login.php';
	const CONTROL_PANEL = 'controlpanel.php';
}
?>