<?php
require_once('namespace.php');
require_once(dirname(__FILE__) . '/../Common/namespace.php');
require_once(dirname(__FILE__) . '/../Database/Commands/namespace.php');

class Authorization implements IAuthorization 
{	
	private $passwordValidation = null;
	
	public function __construct()
	{
	}
	
	public function SetValidation(PasswordValidation $validator)
	{
		$this->passwordValidation = $validator;
	}
	
	private function GetValidation()
	{
		if (isnull($this->passwordValidation))
		{
			$this->passwordValidation = new PasswordValidation();
		}
		
		return $this->passwordValidation;
	}
	
	public function Validate($username, $password)
	{
		$command = new AuthorizationCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);		
		
		if ($row = $reader->GetRow())
		{
			$userpassword = $row[ColumnNames::PASSWORD];
			$salt = $row[ColumnNames::SALT];
			
			$encryption = new PasswordEncryption();
			
			return $userpassword == $encryption->Encrypt($password, $salt);
		}
		
		return false;
	}
	
	public function Login($username, $persist)
	{
		$command = new LoginCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);
		
		if ($row = $reader->GetRow())
		{
			$userid = $row[ColumnNames::USER_ID];
			$command = new UpdateLoginTimeCommand($userid, LoginTime::Now());
			ServiceLocator::GetDatabase()->Execute($command);
			
			$this->SetUserSession($row);
		}	
	}
	
	private function SetUserSession($row)
	{
		$user = new UserSession($row[ColumnNames::USER_ID]);
		$user->Email = $row[ColumnNames::EMAIL];
		$user->FirstName = $row[ColumnNames::FIRST_NAME];
		$user->LastName = $row[ColumnNames::LAST_NAME];
		
		$isAdmin = ($user->Email == Configuration::GetKey(ConfigKeys::ADMIN_EMAIL)) || (bool)$row[ColumnNames::IS_ADMIN];
		$user->IsAdmin = $isAdmin;
		
		$tzOffset = intval($row[ColumnNames::TIMEZONE]) - intval(Configuration::GetKey(ConfigKeys::SERVER_TIMEZONE));
		$user->TimeOffset = $tzOffset;
		
		ServiceLocator::GetServer()->SetSession(SessionKeys::USER_SESSION, $user);
	}
}
?>