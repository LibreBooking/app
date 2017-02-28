<?php
/**
Copyright 2011-2017 Nick Korbel

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
	private $passwordEncryption;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * @var IRegistrationNotificationStrategy
	 */
	private $notificationStrategy;

	/**
	 * @var IRegistrationPermissionStrategy
	 */
	private $permissionAssignmentStrategy;

	public function __construct($passwordEncryption = null, $userRepository = null, $notificationStrategy = null, $permissionAssignmentStrategy = null)
	{
		$this->passwordEncryption = $passwordEncryption;
		$this->userRepository = $userRepository;
		$this->notificationStrategy = $notificationStrategy;
		$this->permissionAssignmentStrategy = $permissionAssignmentStrategy;

		if ($passwordEncryption == null)
		{
			$this->passwordEncryption = new PasswordEncryption();
		}

		if ($userRepository == null)
		{
			$this->userRepository = new UserRepository();
		}

		if ($notificationStrategy == null)
		{
			$this->notificationStrategy = new RegistrationNotificationStrategy();
		}

		if ($permissionAssignmentStrategy == null)
		{
			$this->permissionAssignmentStrategy = new RegistrationPermissionStrategy();
		}
	}

	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $language,
							 $homepageId, $additionalFields = array(), $attributeValues = array(), $groups = null)
	{
		$homepageId = empty($homepageId) ? Pages::DEFAULT_HOMEPAGE_ID : $homepageId;
		$encryptedPassword = $this->passwordEncryption->EncryptPassword($password);
		$timezone = empty($timezone) ? Configuration::Instance()->GetKey(ConfigKeys::DEFAULT_TIMEZONE) : $timezone;

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

		$userId = $this->userRepository->Add($user);
		if ($user->Id() != $userId)
		{
			$user->WithId($userId);
		}
		$this->permissionAssignmentStrategy->AddAccount($user);
		$this->notificationStrategy->NotifyAccountCreated($user, $password);

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
		$userId = $this->userRepository->UserExists($emailAddress, $loginName);

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

			$encryptedPassword = $this->passwordEncryption->EncryptPassword($user->Password());
			$command = new UpdateUserFromLdapCommand($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $user->Phone(), $user->Organization(), $user->Title());
			ServiceLocator::GetDatabase()->Execute($command);

			if ($user->GetGroups() != null)
			{
				$updatedUser = $this->userRepository->LoadByUsername($user->Username());
				$updatedUser->ChangeGroups($user->GetGroups());
				$this->userRepository->Update($updatedUser);
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
}

class AdminRegistration extends Registration
{
	protected function CreatePending()
	{
		return false;
	}
}

class GuestRegistration extends Registration
{
	protected function CreatePending()
	{
		return false;
	}
}