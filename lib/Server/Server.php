<?php
require_once('namespace.php');

class Server
{
	public function __construct()
	{	
	}
	
	public function SetCookie(Cookie $cookie)
	{
		setcookie($cookie->Name, $cookie->Value, $cookie->Expiration, $cookie->Path);
	}
	
	public function GetCookie($name)
	{
		if (isset($_COOKIE[$name]))
		{
			return $_COOKIE[$name];
		}
		return null;
	}
	
	public function SetSession($name, $value)
	{
		$_SESSION[$name] = $value;
	}
	
	public function GetSession($name)
	{
		if (isset($_SESISON[$name]))
		{
			return $_SESSION[$name];
		}
		return null;
	}
	
	public function GetQuerystring($name)
	{
		if (isset($_GET[$name]))
		{
			return $_GET[$name];
		}
		return null;
	}
	
	public function GetForm($name)
	{
		if (isset($_POST[$name]))
		{
			return $_POST[$name];
		}
		return null;
	}
	
	public function GetUrl()
	{
		return urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']);	
	}
}
?>