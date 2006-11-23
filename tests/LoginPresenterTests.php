<?php
require_once('PHPUnit.php');
require_once('../Presenters/LoginPresenter.php');
require_once('../lib/Authorization/namespace.php');


class FakeServer extends Server
{
	var $Cookies;
	var $Session;
	var $Post;
	var $Get;
	
	function FakeServer()
	{
	}
	
	function SetCookie($cookie)
	{
		$this->Cookies[$cookie->Name] = $cookie;
	}
	
	function GetCookie($name)
	{
		return $this->Cookies[$name];
	}
	
}

class Cookie
{
	var $Name;
	var $Value;
	var $Expiration;
	var $Path;
	
	function Cookie($name, $value, $expiration, $path)
	{
		$this->Name = $name;
		$this->Value = $value;
		$this->Expiration = $expiration;
		$this->Path = $path;
	}
}

class Server
{
	function Server()
	{	
	}
	
	function SetCookie($cookie)
	{
		setcookie($cookie->$Name, $cookie->$Value, $cookie->Expiration, $cookie->Path);
	}
	
	function GetCookie($name)
	{
		return $_COOKIE[$name];
	}
}

class LoginPresenterTests extends PHPUnit_TestCase
{
	var $auth;
	var $page;
	var $server;
	
	function setup()
	{
		$this->auth = new FakeAuth();		
		$this->page = new FakeLoginPage();
		$this->server = new FakeServer();
		
		$this->page->_EmailAddress = 'nkorbel@phpscheduleit.org';
		$this->page->_Password = 'somepassword';
		$this->page->_PersistLogin = true;
	}
	
	function teardown()
	{
		$this->auth = null;
		$this->page = null;
	}
	
	function testLoginCallsAuthValidate() 
	{	
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->Login($this->auth);
		
		$this->assertEquals($this->page->_EmailAddress, $this->auth->_LastLogin);
		$this->assertEquals($this->page->_Password, $this->auth->_LastPassword);
	}
	
	function testSuccessfulValidateCallsLogin()
	{
		$this->auth->_ValidateResult = true;
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->Login($this->auth);
		
		$this->assertEquals($this->page->_EmailAddress, $this->auth->_LastLogin);
		$this->assertEquals($this->page->_PersistLogin, $this->auth->_LastPersist);
	}
	
	function testSuccessfulValidateSetsNeededServerVarsAndRedirects()
	{
		$id = '12345';
		$this->auth->_LastLoginId = $id;
		$this->auth->_ValidateResult = true;
		
		$this->page->_PersistLogin = true;
		
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->Login($this->auth);
		
		$cookie = new Cookie('id', $id, time() + 2592000, '/');
		
		//$this->assertEquals("", $this->page->_LastRedirect);		
		$this->assertEquals($cookie, $this->server->GetCookie('id'));
	}
}

class FakeLoginPage extends ILoginPage
{
	var $_EmailAddress;
	var $_Password;
	var $_PersistLogin = false;
	var $_LastRedirect;
	
	function get_EmailAddress()
	{ 
		return $this->_EmailAddress;
	}
	
	function get_Password()
	{ 
		return $this->_Password;
	}
	
	function get_PersistLogin()
	{
		return $this->_PersistLogin;
	}
	
	function Redirect($url)
	{
		$this->_LastRedirect = $url;
	}
}

class FakeAuth extends IAuthorization
{
	var $_LastLogin;
	var $_LastPassword;
	var $_LastPersist;
	var $_LastLoginId;
	
	var $_ValidateResult = false;
	
	function Validate($username, $password)
	{
		$this->_LastLogin = $username;
		$this->_LastPassword = $password;
		
		return $this->_ValidateResult;
	}
	
	function Login($username, $persist)
	{
		$this->_LastLogin = $username;
		$this->_LastPersist = $persist;
		$this->_LastLoginId;
		
					if ($this->_page->get_PersistLogin())
			{
				$this->_server->SetCookie(new Cookie('id', $id, time() + 2592000, '/'));
			}
	}
}
?>