<?php
require_once(ROOT_DIR . 'Domain/namespace.php');

class Registration implements IRegistration 
{
	private $_passwordEncryption;
	
	public function __construct($passwordEncryption = null)
	{
		$this->_passwordEncryption = $passwordEncryption;
		
		if ($passwordEncryption == null)
		{
			$this->_passwordEncryption = new PasswordEncryption();
		}
	}
	
	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $language, $homepageId, $additionalFields = array())
	{
		$salt = $this->_passwordEncryption->Salt();
		$encryptedPassword = $this->_passwordEncryption->Encrypt($password, $salt);
		
		$registerCommand = new RegisterUserCommand(
					$username, $email, $firstName, $lastName,
					$encryptedPassword, $salt, $timezone, $language, $homepageId, 
	     			$additionalFields['phone'], $additionalFields['organization'], $additionalFields['position'],
				AccountStatus::ACTIVE
				);			
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($registerCommand);
		
		$this->AutoAssignPermissions($userId);
	}
	
	public function UserExists($loginName, $emailAddress)
	{
		$exists = false;
		$reader = ServiceLocator::GetDatabase()->Query(new CheckUserExistanceCommand($loginName, $emailAddress));
		
		if ($row = $reader->GetRow())
		{
			$exists = true;
		}
		
		return $exists;
	}
	
	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);	
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
	}
}
?>