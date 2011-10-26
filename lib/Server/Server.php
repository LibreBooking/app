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
		if (!is_null($value))
		{
			@session_start();
		}

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
			return htmlentities($_GET[$name]);
		}
		return null;
	}
	
	public function GetForm($name)
	{
		if (isset($_POST[$name]))
		{
			if (is_array($_POST[$name]))
			{
				return $_POST[$name];
			}
			return htmlentities($_POST[$name]);
		}
		return null;
	}
	
	public function GetFile($name)
	{
		if (isset($_FILES[$name]))
		{
			return new UploadedFile($_FILES[$name]);
		}
		return null;
	}
	
	public function GetUrl()
	{
		$url = urlencode($_SERVER['PHP_SELF']);
		
		if (isset($_SERVER['QUERY_STRING']))
		{
			$url.= '?' . urlencode($_SERVER['QUERY_STRING']);	
		}
		
		return $url;
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

	/**
	 * @param $userSession UserSession
	 * @return void
	 */
	public function SetUserSession($userSession)
	{
		$this->SetSession(SessionKeys::USER_SESSION, $userSession);
	}

	/**
	 * @return string
	 */
	public function GetRequestMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
}
?>