<?php
require_once('../Presenters/RegistrationPresenter.php');
require_once('../Pages/RegistrationPage.php');
require_once('../lib/Common/namespace.php');
require_once('../lib/Authorization/namespace.php');
require_once('fakes/FakeServer.php');
require_once('fakes/FakePageBase.php');

class RegisterPresenterTests extends PHPUnit_Framework_TestCase
{
	private $page;
	private $server;
	private $presenter;
	private $fakeReg;
	
	private $login = 'testlogin';
	private $email = 'test@test.com';
	private $fname = 'First';
	private $lname = 'Last';
	private $phone = '123.123.1234';
	private $password = 'password';
	private $confirm = 'password';
	private $timezone = 'US/Eastern';
	
	public function setup()
	{
		$this->page = new FakeRegistrationPage();
		$this->server = new FakeServer();
		$this->fakeReg = new FakeRegistration();
		
		$this->presenter = new RegistrationPresenter($this->page, $this->fakeReg);
		
		ServiceLocator::SetServer($this->server);
	}
	
	public function teardown()
	{
		$this->auth = null;
		$this->page = null;
//		$resources =& Resources::GetInstance();
//		$resources = null;

		Configuration::Reset();
		
		$this->server = null;
	}
	
	public function testSetsSelectedTimezoneToServerDefault()
	{
		$expectedTimezone = "US/Central";
		Configuration::SetKey(ConfigKeys::SERVER_TIMEZONE, $expectedTimezone);
		
		$this->presenter->PageLoad();
		
		$this->assertEquals($this->page->_Timezone, $expectedTimezone);
	}
	
	public function testLoadsAllTimezones()
	{
		$numberOfTimezones = count($GLOBALS[GlobalKeys::TIMEZONES]);
		$this->presenter->PageLoad();
		
		$this->assertEquals($numberOfTimezones, count($this->page->_TimezoneValues));
		$this->assertEquals($numberOfTimezones, count($this->page->_TimezoneOutput));
	}
	
	public function testPresenterRegistersIfAllFieldsAreValid()
	{		
		$this->page->SetLoginName($this->login);
		$this->page->SetEmail($this->email);
		$this->page->SetFirstName($this->fname);
		$this->page->SetLastName($this->lname);
		$this->page->SetPhone($this->phone);
		$this->page->SetPassword($this->password);
		$this->page->SetPasswordConfirm($this->confirm);
		$this->page->SetTimezone($this->timezone);
		
		$additionalFields = array($this->phone);
		
		$this->Page->_IsValid = true;
		
		$this->presenter = new RegistrationPresenter($this->page, $this->fakeReg);
		$this->presenter->Register();
		
		$this->assertTrue($this->fakeReg->_RegisterCalled);
		$this->assertEquals($this->login, $this->fakeReg->_Login);
		$this->assertEquals($this->email, $this->fakeReg->_Email);
		$this->assertEquals($this->fname, $this->fakeReg->_First);
		$this->assertEquals($this->lname, $this->fakeReg->_Last);
		$this->assertEquals($this->password, $this->fakeReg->_Password);
		$this->assertEquals($this->confirm, $this->fakeReg->_Confirm);
		$this->assertEquals($this->timezone, $this->fakeReg->_Timezone);
		$this->assertEquals($additionalFields, $this->fakeReg->_AdditionalFields);
	}
}

class FakeRegistrationPage extends FakePageBase implements IRegistrationPage
{	
	public $_Timezone;
	public $_TimezoneValues;
	public $_TimezoneOutput;
	public $_LoginName;
	public $_Email;
	public $_FirstName;
	public $_LastName;
	public $_PhoneNumber;
	public $_Password;
	public $_PasswordConfirm;
	
	public function SetTimezone($timezone)
	{
		$this->_Timezone = $timezone;
	}
	
	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->_TimezoneValues = $timezoneValues;
		$this->_TimezoneOutput = $timezoneOutput;
	}
		
	public function SetLoginName($loginName)
	{
		$this->_LoginName = $loginName;	
	}
	
	public function SetEmail($email)
	{
		$this->_Email = $email;	
	}	
	
	public function SetFirstName($firstName)
	{
		$this->_FirstName = $firstName;	
	}	
	
	public function SetLastName($lastName)
	{
		$this->_LastName = $lastName;	
	}	
	
	public function SetPhone($phoneNumber)
	{
		$this->_PhoneNumber = $phoneNumber;	
	}	
	
	public function SetPassword($password)
	{
		$this->_Password = $password;	
	}	
	
	public function SetPasswordConfirm($passwordConfirm)
	{
		$this->_PasswordConfirm = $passwordConfirm;	
	}
	
	public function GetTimezone()
	{
		return $this->_Timezone;
	}
	
	public function GetLoginName()
	{
		return $this->_LoginName;
	}
	
	public function GetEmail()
	{
		return $this->_Email;
	}	
	
	public function GetFirstName()
	{
		return $this->_FirstName;
	}	
	
	public function GetLastName()
	{
		return $this->_LastName;
	}	
	
	public function GetPhone()
	{
		return $this->_PhoneNumber;
	}	
	
	public function GetPassword()
	{
		return $this->_Password;
	}	
	
	public function GetPasswordConfirm()
	{
		return $this->_PasswordConfirm;
	}
}

class FakeRegistration implements IRegistration
{
	public $_RegisterCalled;
	public $_UserExists;
	public $_ExistsCalled = false;
	public $_LastLogin;
	public $_LastEmail;
	public $_Login;
	public $_Email;
	public $_First;
	public $_Last;
	public $_Password;
	public $_Confirm;
	public $_Timezone;
	public $_AdditionalFields;
	
	public function Register($login, $email, $firstName, $lastName, $password, $confirm, $timezone, $additionalFields = array())
	{
		$this->_RegisterCalled = true;
		$this->_Login = $login;
		$this->_Email = $email;
		$this->_First = $firstName;
		$this->_Last = $lastName;
		$this->_Phone = $phone;
		$this->_Password = $password;
		$this->_Confirm = $confirm;
		$this->_Timezone = $timezone;
		$this->_AdditionalFields = $additionalFields;
	}
	
	public function UserExists($loginName, $emailAddress)
	{
		$this->_ExistsCalled = true;
		$this->_LastLogin = $loginName;
		$this->_LastEmail = $emailAddress;
		
		return $this->_UserExists;
	}
}
?>