<?php
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
	
	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $homepageId, $additionalFields = array())
	{
		$salt = $this->_passwordEncryption->Salt();
		$encryptedPassword = $this->_passwordEncryption->Encrypt($password, $salt);
		
		$usingLoginNames = Configuration::Instance()->GetKey(ConfigKeys::USE_LOGON_NAME, new BooleanConverter());
		$usernameToInsert = $usingLoginNames ? $username : $email;
		
		$registerCommand = new RegisterUserCommand(
					$usernameToInsert, $email, $firstName, $lastName, 
					$encryptedPassword, $salt, $timezone, $homepageId, 
					$additionalFields['phone'], $additionalFields['institution'], $additionalFields['position'], 
					AccountStatus::AWAITING_ACTIVATION
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