<?php
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Presenters/RegistrationMiniPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');


interface IRegistrationMiniPage extends IPage
{
	public function RegisterClicked();
	
	public function SetUseLoginName($useLoginName);
	
	public function SetLoginName($loginName);	
	public function SetEmail($email);
	public function SetFirstName($firstName);
	public function SetLastName($lastName);
	public function SetPassword($password);
	public function SetPasswordConfirm($passwordConfirm);
	
	public function GetLoginName();	
	public function GetEmail();
	public function GetFirstName();
	public function GetLastName();
	public function GetPassword();
	public function GetPasswordConfirm();
}

class RegistrationMiniPage extends Page implements IRegistrationMiniPage
{
	public function __construct()
	{
		parent::__construct('RegistrationMini');
		
		$this->_presenter = new RegistrationMiniPresenter($this);			
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$this->smarty->display('register-mini.tpl');				
	}
	
	public function RegisterClicked()
	{
		return $this->GetForm(Actions::REGISTER);
	}
	
	public function SetUseLoginName($useLoginName)
	{
		$this->Set('UseLoginName', $useLoginName);	
	}
	
	public function SetLoginName($loginName)
	{
		$this->Set('LoginName', $loginName);	
	}	
	
	public function SetEmail($email)
	{
		$this->Set('Email', $email);	
	}	
	
	public function SetFirstName($firstName)
	{
		$this->Set('FirstName', $firstName);	
	}
	
	public function SetLastName($lastName)
	{
		$this->Set('LastName', $lastName);	
	}	
	
	public function SetPassword($password)
	{
		$this->Set('Password', $password);	
	}	
	
	public function SetPasswordConfirm($passwordConfirm)
	{
		$this->Set('PasswordConfirm', $passwordConfirm);	
	}
	
	public function GetLoginName()
	{
		return $this->GetForm(FormKeys::LOGIN);
	}
	
	public function GetEmail()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}
	
	public function GetFirstName()
	{
		return $this->GetForm(FormKeys::FIRST_NAME);
	}
	
	public function GetLastName()
	{
		return $this->GetForm(FormKeys::LAST_NAME);
	}
	
	public function GetPassword()
	{
		return $this->GetForm(FormKeys::PASSWORD);
	}
	
	public function GetPasswordConfirm()
	{
		return $this->GetForm(FormKeys::PASSWORD_CONFIRM);
	}
}
?>