<?php
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class FakeAuth implements IAuthorization
{
	public $_LastLogin;
	public $_LastPassword;
	public $_LastPersist;
	public $_LastLoginId;
	public $_CookieLoginCalled = false;
	public $_LastLoginCookie;
	public $_CookieValidateResult = false;
	public $_LoginCalled = false;
    
	public $_ValidateResult = false;
	
	public function Validate($username, $password)
	{
		$this->_LastLogin = $username;
		$this->_LastPassword = $password;
		
		return $this->_ValidateResult;
	}
	
	public function Login($username, $persist)
	{
        $this->_LoginCalled = true;
		$this->_LastLogin = $username;
		$this->_LastPersist = $persist;
	}
	
	public function CookieLogin($cookie)
	{
		$this->_CookieLoginCalled = true;
		$this->_LastLoginCookie = $cookie;
		
		return $this->_CookieValidateResult;
	}
	
	public function AreCredentialsKnown()
	{
		return true;
	}
	
	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		
	}
}
?>