<?php
/**
 * Copyright 2011-2020 Nick Korbel
 * Copyright 2012-2014 Moritz Schepp, IST Austria
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');
require_once(ROOT_DIR . 'Domain/Values/RoleLevel.php');

class Authentication implements IAuthentication
{
	/**
	 * @var PasswordMigration
	 */
	private $passwordMigration = null;

	/**
	 * @var IRoleService
	 */
	private $roleService;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * @var IFirstRegistrationStrategy
	 */
	private $firstRegistration;
	/**
	 * @var IGroupRepository
	 */
	private $groupRepository;

	public function __construct(IRoleService $roleService, IUserRepository $userRepository, IGroupRepository $groupRepository)
	{
		$this->roleService = $roleService;
		$this->userRepository = $userRepository;
		$this->groupRepository = $groupRepository;
	}

	public function SetMigration(PasswordMigration $migration)
	{
		$this->passwordMigration = $migration;
	}

	/**
	 * @return PasswordMigration
	 */
	private function GetMigration()
	{
		if (is_null($this->passwordMigration))
		{
			$this->passwordMigration = new PasswordMigration();
		}

		return $this->passwordMigration;
	}

	public function SetFirstRegistrationStrategy(IFirstRegistrationStrategy $migration)
	{
		$this->firstRegistration = $migration;
	}

	/**
	 * @return IFirstRegistrationStrategy
	 */
	private function GetFirstRegistrationStrategy()
	{
		if (is_null($this->firstRegistration))
		{
			$this->firstRegistration = new SetAdminFirstRegistrationStrategy();
		}

		return $this->firstRegistration;
	}

	public function Validate($username, $passwordPlainText)
	{
		if (($this->ShowUsernamePrompt() && empty($username)) || ($this->ShowPasswordPrompt() && empty($passwordPlainText)))
		{
			return false;
		}

		Log::Debug('Trying to log in as: %s', $username);

		$command = new AuthorizationCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);
		$valid = false;

		if ($row = $reader->GetRow())
		{
			Log::Debug('User was found: %s', $username);
			$migration = $this->GetMigration();
			$password = $migration->Create($passwordPlainText, $row[ColumnNames::OLD_PASSWORD], $row[ColumnNames::PASSWORD]);
			$salt = $row[ColumnNames::SALT];

			if ($password->Validate($salt))
			{
				$password->Migrate($row[ColumnNames::USER_ID]);
				$valid = true;
			}
		}

		Log::Debug('User: %s, was validated: %d', $username, $valid);
		return $valid;
	}

	public function Login($username, $loginContext)
	{
		Log::Debug('Logging in with user: %s', $username);

		$user = $this->userRepository->LoadByUsername($username);
		if ($user->StatusId() == AccountStatus::ACTIVE)
		{
			$loginData = $loginContext->GetData();
			$loginTime = LoginTime::Now();
			$language = $user->Language();

			if (!empty($loginData->Language))
			{
				$language = $loginData->Language;
			}

			$user->Login($loginTime, $language);
			$this->userRepository->Update($user);

			$user = $this->GetFirstRegistrationStrategy()->HandleLogin($user, $this->userRepository, $this->groupRepository);

			return $this->GetUserSession($user, $loginTime);
		}

		return new NullUserSession();
	}

	public function Logout(UserSession $userSession)
	{
		// hook for implementing Logout logic
	}

	public function AreCredentialsKnown()
	{
		return false;
	}

	public function HandleLoginFailure(IAuthenticationPage $loginPage)
	{
		$loginPage->SetShowLoginError();
	}

	/**
	 * @param User $user
	 * @param string $loginTime
	 * @return UserSession
	 */
	private function GetUserSession(User $user, $loginTime)
	{
		$userSession = new UserSession($user->Id());
		$userSession->Email = $user->EmailAddress();
		$userSession->FirstName = $user->FirstName();
		$userSession->LastName = $user->LastName();
		$userSession->Timezone = $user->Timezone();
		$userSession->HomepageId = $user->Homepage();
		$userSession->LanguageCode = $user->Language();
		$userSession->LoginTime = $loginTime;
		$userSession->PublicId = $user->GetPublicId();
		$userSession->ScheduleId = $user->GetDefaultScheduleId();

		$userSession->IsAdmin = $this->roleService->IsApplicationAdministrator($user);
		$userSession->IsGroupAdmin = $this->roleService->IsGroupAdministrator($user);
		$userSession->IsResourceAdmin = $this->roleService->IsResourceAdministrator($user);
		$userSession->IsScheduleAdmin = $this->roleService->IsScheduleAdministrator($user);
		$userSession->CSRFToken = CSRFToken::Create();

		foreach ($user->Groups() as $group)
		{
			$userSession->Groups[] = $group->GroupId;
		}

		foreach ($user->GetAdminGroups() as $group)
		{
			$userSession->AdminGroups[] = $group->GroupId;
		}

		return $userSession;
	}

	public function ShowUsernamePrompt()
	{
		return true;
	}

	public function ShowPasswordPrompt()
	{
		return true;
	}

	public function ShowPersistLoginPrompt()
	{
		return true;
	}

	public function ShowForgotPasswordPrompt()
	{
		return true;
	}

	public function AllowUsernameChange()
	{
		return true;
	}

	public function AllowEmailAddressChange()
	{
		return true;
	}

	public function AllowPasswordChange()
	{
		return true;
	}

	public function AllowNameChange()
	{
		return true;
	}

	public function AllowPhoneChange()
	{
		return true;
	}

	public function AllowOrganizationChange()
	{
		return true;
	}

	public function AllowPositionChange()
	{
		return true;
	}

	public function GetRegistrationUrl()
	{
		return '';
	}

	public function GetPasswordResetUrl()
	{
		return '';
	}
}