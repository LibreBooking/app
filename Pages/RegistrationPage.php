<?php
require_once('Page.php');
require_once(dirname(__FILE__) . '/../Presenters/RegistrationPresenter.php');
require_once(dirname(__FILE__) . '/../Zend/Loader.php');
require_once(dirname(__FILE__) . '/../config/timezones.php');
require_once(dirname(__FILE__) . '/../lib/Authorization/namespace.php');


interface IRegistrationPage extends IPage
{
	public function SetTimezones($timezoneValues, $timezoneOutput);
	public function SetTimezone($timezone);
	public function SetLoginName($loginName);	
	public function SetEmail($email);
	public function SetFirstName($firstName);
	public function SetLastName($lastName);
	public function SetPhone($phoneNumber);
	public function SetPassword($password);
	public function SetPasswordConfirm($passwordConfirm);
	
	public function GetTimezone();
	public function GetLoginName();	
	public function GetEmail();
	public function GetFirstName();
	public function GetLastName();
	public function GetPhone();
	public function GetPassword();
	public function GetPasswordConfirm();
}

class RegistrationPage extends Page implements IRegistrationPage
{
	public function __construct()
	{
		parent::__construct('Registration', $smarty);
		
		//Modules::Load('Registration')
		$this->_presenter = new RegistrationPresenter($this, new Registration());			
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$this->smarty->display('register.tpl');				
	}
	
	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->smarty->assign('TimezoneValues', $timezoneValues);
		$this->smarty->assign('TimezoneOutput', $timezoneOutput);
	}
	
	public function SetTimezone($timezone)
	{
		$this->smarty->assign('Timezone', $timezone);	
	}
	
	public function SetLoginName($loginName)
	{
		$this->smarty->assign('LoginName', $loginName);	
	}	
	
	public function SetEmail($email)
	{
		$this->smarty->assign('Email', $email);	
	}	
	
	public function SetFirstName($firstName)
	{
		$this->smarty->assign('FirstName', $firstName);	
	}
	
	public function SetLastName($lastName)
	{
		$this->smarty->assign('LastName', $lastName);	
	}	
	
	public function SetPhone($phoneNumber)
	{
		$this->smarty->assign('PhoneNumber', $phoneNumber);	
	}	
	
	public function SetPassword($password)
	{
		$this->smarty->assign('Password', $password);	
	}	
	
	public function SetPasswordConfirm($passwordConfirm)
	{
		$this->smarty->assign('PasswordConfirm', $passwordConfirm);	
	}
	
	public function GetTimezone()
	{
		return $this->server->GetForm(FormKeys::TIMEZONE);
	}
	
	public function GetLoginName()
	{
		return $this->server->GetForm(FormKeys::LOGIN);
	}
	
	public function GetEmail()
	{
		return $this->server->GetForm(FormKeys::EMAIL);
	}
	
	public function GetFirstName()
	{
		return $this->server->GetForm(FormKeys::FIRST_NAME);
	}
	
	public function GetLastName()
	{
		return $this->server->GetForm(FormKeys::LAST_NAME);
	}
	
	public function GetPhone()
	{
		return $this->server->GetForm(FormKeys::PHONE);
	}
	
	public function GetPassword()
	{
		return $this->server->GetForm(FormKeys::PASSWORD);
	}
	
	public function GetPasswordConfirm()
	{
		return $this->server->GetForm(FormKeys::PASSWORD_CONFIRM);
	}
}
?>