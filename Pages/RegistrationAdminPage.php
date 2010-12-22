<?php
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Presenters/RegistrationAdminPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');


interface IRegistrationAdminPage extends IPage
{
	public function SaveClicked();
		
	public function SetFirstName($firstName);
	public function SetLastName($lastName);
	public function SetUsername($username);	
	public function SetEmail($email);
	public function SetPassword($password);
	public function SetPasswordConfirm($passwordConfirm);
	public function SetOrganization($organization);
	public function SetGroup($group);
	public function SetPosition($position);
	public function SetAddress($address);
	public function SetPhone($phone);
    public function SetHomepage($homepage);
	public function SetTimezone($timezone);
	
	public function GetFirstName();
	public function GetLastName();
	public function GetUsername();	
	public function GetEmail();
	public function GetPassword();
	public function GetPasswordConfirm();
	public function GetOrganization();
	public function GetGroup();
	public function GetPosition();
	public function GetAddress();
	public function GetPhone();
    public function GetHomepage();
	public function GetTimezone();
}

class RegistrationAdminPage extends Page implements IRegistrationAdminPage
{
	public function __construct()
	{
		parent::__construct('RegistrationAdmin');
		
		$this->_presenter = new RegistrationAdminPresenter($this);			
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		$this->smarty->display('register-admin.tpl');				
	}
	
	public function SaveClicked()
	{
		return $this->GetForm(Actions::SAVE);
	}

	public function SetFirstName($firstName)
	{
		$this->Set('FirstName', $firstName);	
	}
	
	public function SetLastName($lastName)
	{
		$this->Set('LastName', $lastName);	
	}	
		
	public function SetUsername($username)
	{
		$this->Set('Username', $username);	
	}	
	
	public function SetEmail($email)
	{
		$this->Set('Email', $email);	
	}	
		
	public function SetPassword($password)
	{
		$this->Set('Password', $password);	
	}	
	
	public function SetPasswordConfirm($passwordConfirm)
	{
		$this->Set('PasswordConfirm', $passwordConfirm);	
	}

	public function SetOrganization($organization)
    {
    	$this->Set('Organization', $organization);
    }

    public function SetGroup($group)
    {
    	$this->Set('Group', $group);
    }

    public function SetPosition($position)
    {
    	$this->Set('Position', $position);
    }

    public function SetAddress($address)
    {
    	$this->Set('Address', $address);
    }

    public function SetPhone($phone)
    {
    	$this->Set('Phone', $phone);
    }

    public function SetHomepage($homepage)
    {
    	$this->Set('Homepage', $homepage);
    }

    public function SetTimezone($timezone)
    {
    	$this->Set('Timezone', $timezone);
    }
		
	public function GetFirstName()
	{
		return $this->GetForm(FormKeys::FIRST_NAME);
	}
	
	public function GetLastName()
	{
		return $this->GetForm(FormKeys::LAST_NAME);
	}

	public function GetUsername()
	{
		return $this->GetForm(FormKeys::USERNAME);
	}
	
	public function GetEmail()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}
	
	public function GetPassword()
	{
		return $this->GetForm(FormKeys::PASSWORD);
	}
	
	public function GetPasswordConfirm()
	{
		return $this->GetForm(FormKeys::PASSWORD_CONFIRM);
	}

    public function GetOrganization()
    {
            return $this->GetForm(FormKeys::ORGANIZATION);
    }

    public function GetGroup()
    {
            return $this->GetForm(FormKeys::GROUP);
    }

    public function GetPosition()
    {
            return $this->GetForm(FormKeys::POSITION);
    }

    public function GetAddress()
    {
            return $this->GetForm(FormKeys::ADDRESS);
    }

    public function GetPhone()
    {
            return $this->GetForm(FormKeys::PHONE);
    }

    public function GetHomepage()
    {
            return $this->GetForm(FormKeys::DEFAULT_HOMEPAGE);
    }

    public function GetTimezone()
    {
            return $this->GetForm(FormKeys::TIMEZONE);
    }
}
?>