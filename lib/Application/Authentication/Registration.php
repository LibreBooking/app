<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationEvents.php');

class Registration implements IRegistration
{
	/**
	 * @var PasswordEncryption
	 */
	private $_passwordEncryption;

	/**
	 * @var IUserRepository
	 */
	private $_userRepository;

	public function __construct($passwordEncryption = null, $userRepository = null)
	{
		$this->_passwordEncryption = $passwordEncryption;
		$this->_userRepository = $userRepository;

		if ($passwordEncryption == null)
		{
			$this->_passwordEncryption = new PasswordEncryption();
		}

		if ($userRepository == null)
		{
			$this->_userRepository = new UserRepository();
		}
	}

	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $language,
							 $homepageId, $additionalFields = array(), $attributeValues = array(), $groups = null)
	{
		$encryptedPassword = $this->_passwordEncryption->EncryptPassword($password);

		$attributes = new UserAttribute($additionalFields);

		if ($this->CreatePending())
		{
			$user = User::CreatePending($firstName, $lastName, $email, $username, $language, $timezone, $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $homepageId);
		}
		else
		{
			$user = User::Create($firstName, $lastName, $email, $username, $language, $timezone, $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $homepageId);
		}
		$user->ChangeAttributes($attributes->Get(UserAttribute::Phone), $attributes->Get(UserAttribute::Organization), $attributes->Get(UserAttribute::Position));
		$user->ChangeCustomAttributes($attributeValues);

		if ($groups != null)
		{
			$user->WithGroups($groups);
		}

		if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_AUTO_SUBSCRIBE_EMAIL, new BooleanConverter()))
		{
			foreach (ReservationEvent::AllEvents() as $event)
			{
				$user->ChangeEmailPreference($event, true);
			}
		}

		$userId = $this->_userRepository->Add($user);
		$this->AutoAssignPermissions($userId);

		return $user;
	}

	/**
	 * @return bool
	 */
	protected function CreatePending()
	{
		return Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_REQUIRE_ACTIVATION, new BooleanConverter());
	}

	public function UserExists($loginName, $emailAddress)
	{
		$userId = $this->_userRepository->UserExists($emailAddress, $loginName);

		return !empty($userId);
	}

	public function Synchronize(AuthenticatedUser $user, $insertOnly = false)
	{
		if ($this->UserExists($user->UserName(), $user->Email()))
		{
			if ($insertOnly)
			{
				return;
			}

			$encryptedPassword = $this->_passwordEncryption->EncryptPassword($user->Password());
			$command = new UpdateUserFromLdapCommand($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $user->Phone(), $user->Organization(), $user->Title());
			ServiceLocator::GetDatabase()->Execute($command);

			if ($user->GetGroups() != null)
			{
				$updatedUser = $this->_userRepository->LoadByUsername($user->Username());
				$updatedUser->ChangeGroups($user->GetGroups());
				$this->_userRepository->Update($updatedUser);
			}
		}
		else
		{
			$defaultHomePageId = Configuration::Instance()->GetKey(ConfigKeys::DEFAULT_HOMEPAGE, new IntConverter());
			$additionalFields = array('phone' => $user->Phone(), 'organization' => $user->Organization(), 'position' => $user->Title());
			$this->Register($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $user->Password(),
							$user->TimezoneName(),
							$user->LanguageCode(),
							empty($defaultHomePageId) ? Pages::DEFAULT_HOMEPAGE_ID : $defaultHomePageId,
							$additionalFields,
							array(),
							$user->GetGroups());
		}
	}

	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
	}
}

class AdminRegistration extends Registration
{
	protected function CreatePending()
	{
		return false;
	}
}