<?php
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
		@session_start();
		$_SESSION[$name] = $value;
	}
	
	public function GetSession($name)
	{
		@session_start();
		if (isset($_SESSION[$name]))
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
	
	/**
	 * @return UserSession
	 */
	public function GetUserSession()
	{
		$userSession = $this->GetSession(SessionKeys::USER_SESSION);
		
		if (!empty($userSession))
		{
			return $userSession;
		}
		
		return new NullUserSession();
	}
}
?>