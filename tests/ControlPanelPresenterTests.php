<?php
require_once('../Presenters/ControlPanelPresenter.php');
require_once('../Pages/ControlPanelPage.php');
require_once('../lib/Common/namespace.php');
require_once('fakes/FakeServer.php');

class ControlPanelPresenterTests extends PHPUnit_Framework_TestCase
{
	private $page;
	private $server;
	
	public function setup()
	{
		$this->page = new FakeLoginPage();
		$this->server = new FakeServer();
	}
	
	public function teardown()
	{
		$this->auth = null;
		$this->page = null;
		$resources =& Resources::GetInstance();
		$resources = null;
	}
	
	public function testLoginCallsAuthValidate() 
	{	
		$presenter = new LoginPresenter($this->page, $this->server);
		$presenter->Login($this->auth);
		
		$this->assertEquals($this->page->_EmailAddress, $this->auth->_LastLogin);
		$this->assertEquals($this->page->_Password, $this->auth->_LastPassword);
	}
}

class FakeLoginPage implements IControlPanelPage
{
	public $_EmailAddress;
	public $_Password;
	public $_PersistLogin = false;
	public $_LastRedirect;
	public $_ShowRegisterLink;
	public $_PageLoadWasCalled = false;
	public $_Languages = array();
	public $_UseLogonName = false;
	public $_ResumeUrl;
	
	public function PageLoad()
	{
		$this->_PageLoadWasCalled = true;
	}
	
	public function getEmailAddress()
	{ 
		return $this->_EmailAddress;
	}
	
	public function getPassword()
	{ 
		return $this->_Password;
	}
	
	public function getPersistLogin()
	{
		return $this->_PersistLogin;
	}
	
	public function getShowRegisterLink()
	{
		return $this->_ShowRegisterLink;
	}
	
	public function setShowRegisterLink($value)
	{
		$this->_ShowRegisterLink = $value;
	}
	
	public function Redirect($url)
	{
		$this->_LastRedirect = $url;
	}
	
	public function setAvailableLanguages($languages)
	{
		$this->_Languages = $languages;
	}
	
	public function getCurrentLanguage()
	{
		return $this->_CurrentCode;
	}
	
	public function getUseLogonName()
	{
		return $this->_UseLogonName;
	}
	
	public function setUseLogonName($value)
	{
		$this->_UseLogonName = $value;
	}
	
	public function setResumeUrl($value)
	{
		$this->_ResumeUrl = $value;
	}
	
	public function getResumeUrl()
	{
		return $this->_ResumeUrl;
	}
}

class FakeAuth implements IAuthorization
{
	public $_LastLogin;
	public $_LastPassword;
	public $_LastPersist;
	public $_LastLoginId;
	
	public $_ValidateResult = false;
	
	public function Validate($username, $password)
	{
		$this->_LastLogin = $username;
		$this->_LastPassword = $password;
		
		return $this->_ValidateResult;
	}
	
	public function Login($username, $persist)
	{
		$this->_LastLogin = $username;
		$this->_LastPersist = $persist;
		$this->_LastLoginId;
	}
}
?>