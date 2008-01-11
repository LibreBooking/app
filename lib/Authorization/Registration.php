<?php
class Registration implements IRegistration 
{
	public function Register($login, $email, $firstName, $lastName, $password, $confirm, $timezone, $additionalFields = array())
	{
		
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