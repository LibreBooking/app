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
	
	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $additionalFields = array())
	{
		$salt = $this->_passwordEncryption->Salt();
		$encryptedPassword = $this->_passwordEncryption->Encrypt($password, $salt);
		
		$command = new RegisterUserCommand(
					$username, $email, $firstName, $lastName, 
					$encryptedPassword, $salt, $timezone, 
					$additionalFields['phone'], $additionalFields['institution'], $additionalFields['position']
					);
					
		ServiceLocator::GetDatabase()->Execute($command);
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
}
?>