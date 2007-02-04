<?php
require_once('PHPUnit.php');
require_once('../Presenters/LoginPresenter.php');
require_once('../lib/Authorization/namespace.php');
require_once('../Pages/LoginPage.php');
require_once('fakes/FakeServer.php');


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

	function testSuccessfulValidateCallsRedirectToNormalPageWhenNoRequestedPage()
	{
		$this->auth->_ValidateResult = true;
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->Login($this->auth);
		
		$this->assertEquals('ctrlpnl.php', $this->page->_LastRedirect);
	}
	
	function testRedirectsToRequestedPage()
	{
		$redirect = 'something.php';
		$qsKeys = new QueryStringKeys();
		$this->server->SetQuerystring($qsKeys->REDIRECT, $redirect);
		
		$this->auth->_ValidateResult = true;
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->Login($this->auth);
		
		$this->assertEquals($redirect, $this->page->_LastRedirect);
	}
	
	function testPageLoadCallsPagesPageLoad()
	{
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->PageLoad();
		
		$this->assertTrue($this->page->_PageLoadWasCalled);
	}
	
	function testPageLoadSetsVariablesCorrectly()
	{
		$keys = new ConfigKeys();
		
		$config = new Configuration();
		$config->SetKey($keys->ALLOW_REGISTRATION, 'true');
		
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->PageLoad();
		
		$this->assertEquals(true, $this->page->getShowRegisterLink());
	}
}

class FakeLoginPage extends ILoginPage
{
	var $_EmailAddress;
	var $_Password;
	var $_PersistLogin = false;
	var $_LastRedirect;
	var $_ShowRegisterLink;
	var $_PageLoadWasCalled = false;
	
	function PageLoad()
	{
		$this->_PageLoadWasCalled = true;
	}
	
	function getEmailAddress()
	{ 
		return $this->_EmailAddress;
	}
	
	function getPassword()
	{ 
		return $this->_Password;
	}
	
	function getPersistLogin()
	{
		return $this->_PersistLogin;
	}
	
	function getShowRegisterLink()
	{
		return $this->_ShowRegisterLink;
	}
	
	function setShowRegisterLink($value)
	{
		$this->_ShowRegisterLink = $value;
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
	}
}
?>