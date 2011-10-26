<?php
interface IUser
{	
	public function Populate(&$db);
	
	public function Persist(&$db);
	
	public function SetProperty($name, $value);
}

class UserSession
{
	public $UserId = '';
	public $FirstName = '';
	public $LastName = '';
	public $Email = '';
	public $IsAdmin = false;	// TODO: Remove this property in favor of roles
	public $Timezone = '';
	public $HomepageId = 1;
	public $SessionToken = '';
	
	public function __construct($id)
	{
		$this->UserId = $id;
		$this->SessionToken = uniqid();
	}
	
	public function IsLoggedIn()
	{
		return true;
	}
}

class NullUserSession extends UserSession
{
	public function __construct()
	{
		parent::__construct(0);
	}
	
	public function IsLoggedIn()
	{
		return false;
	}
}
?>