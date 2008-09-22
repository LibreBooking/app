<?php
require_once(ROOT_DIR . 'lib/Server/namespace.php');

class FakeServer extends Server
{
	public $Cookies = array();
	public $Session = array();
	public $Post = array();
	public $Get = array();
	public $Form = array();
	
	/**
	 * @var UserSession
	 */
	public $UserSession;
	
	public function FakeServer()
	{
		$this->UserSession = new FakeUserSession();
		$this->SetSession(SessionKeys::USER_SESSION, $this->UserSession);
	}
	
	public function SetCookie(Cookie $cookie)
	{
		$this->Cookies[$cookie->Name] = $cookie;
	}
	
	public function GetCookie($name)
	{
		if (array_key_exists($name, $this->Cookies))
		{
			$cookie = $this->Cookies[$name];
			if (!is_null($cookie))
			{
				return $cookie->Value;
			}
		}
		
		return null;
	}
	
	public function SetSession($name, $value)
	{
		$this->Session[$name] = $value;
	}
	
	public function GetSession($name)
	{
		if (array_key_exists($name, $this->Session))
		{
			return $this->Session[$name];
		}
		return null;
	}
	
	public function SetQuerystring($name, $value)
	{
		$this->Get[$name] = $value;
	}
	
	public function GetQuerystring($name)
	{
		if (isset($this->Get[$name]))
		{
			return $this->Get[$name];
		}
		return null;
	}
	
	public function SetForm($name, $value)
	{
		$this->Form[$name] = $value;
	}
	
	public function GetForm($name)
	{
		if (isset($this->Form[$name]))
		{
			return $this->Form[$name];
		}
		
		return null;
	}
}
?>