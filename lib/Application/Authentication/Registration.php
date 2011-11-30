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

	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $language, $homepageId,
							 $additionalFields = array())
	{
		$encryptedPassword = $this->_passwordEncryption->EncryptPassword($password);

		$registerCommand = new RegisterUserCommand($username, $email, $firstName, $lastName, $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $timezone, $language, $homepageId, $additionalFields['phone'], $additionalFields['organization'], $additionalFields['position'], AccountStatus::ACTIVE);
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

	public function Synchronize(AuthenticatedUser $user)
	{
		if ($this->UserExists($user->UserName(), $user->Email()))
		{
			$encryptedPassword = $this->_passwordEncryption->EncryptPassword($user->Password());
			$command = new UpdateUserFromLdapCommand($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $user->Phone(), $user->Organization(), $user->Title());

			ServiceLocator::GetDatabase()->Execute($command);
		}
		else
		{
			$additionalFields = array('phone' => $user->Phone(), 'organization' => $user->Organization(), 'position' => $user->Title());
			$this->Register($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $user->Password(),
							$user->TimezoneName(),
							$user->LanguageCode(),
							Pages::DEFAULT_HOMEPAGE_ID,
							$additionalFields);
		}
	}

	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
	}
}

?>