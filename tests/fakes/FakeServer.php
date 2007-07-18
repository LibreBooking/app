<?php
require_once(dirname(__FILE__) . '/../../lib/Server/namespace.php');

class FakeServer extends Server
{
	public $Cookies = array();
	public $Session = array();
	public $Post = array();
	public $Get = array();
	public $Form = array();
	
	public function FakeServer()
	{
	}
	
	public function SetCookie(Cookie $cookie)
	{
		$this->Cookies[$cookie->Name] = $cookie;
	}
	
	public function GetCookie($name)
	{
		$cookie = $this->Cookies[$name];
		return $cookie->Value;
	}
	
	public function SetSession($name, $value)
	{
		$this->Session[$name] = $value;
	}
	
	public function GetSession($name)
	{
		if (isset($this->Session[$name]))
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