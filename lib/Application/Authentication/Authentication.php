<?php
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
	 * @var IAuthorizationService
	 */
	private $authorizationService;

	public function __construct(IAuthorizationService $authorizationService)
	{
		$this->authorizationService = $authorizationService;
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

	public function Validate($username, $password)
	{
		Log::Debug('Trying to log in as: %s', $username);

		$command = new AuthorizationCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);
		$valid = false;

		if ($row = $reader->GetRow())
		{
			Log::Debug('User was found: %s', $username);
			$migration = $this->GetMigration();
			$password = $migration->Create($password, $row[ColumnNames::OLD_PASSWORD], $row[ColumnNames::PASSWORD]);

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

	public function Login($username, $persist)
	{
		Log::Debug('Logging in with user: %s, persist: %d', $username, $persist);

		$command = new LoginCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);

		if ($row = $reader->GetRow())
		{
			$loginTime = LoginTime::Now();
			$userid = $row[ColumnNames::USER_ID];
			$emailAddress = $row[ColumnNames::EMAIL];

			$isAdminRole = $this->IsAdminRole($userid, $emailAddress);

			$updateLoginTimeCommand = new UpdateLoginTimeCommand($userid, $loginTime);
			ServiceLocator::GetDatabase()->Execute($updateLoginTimeCommand);

			$this->SetUserSession($row, $isAdminRole);

			if ($persist)
			{
				$this->SetLoginCookie($userid, $loginTime);
			}
		}
	}

	public function Logout(UserSession $userSession)
	{
		Log::Debug('Logout userId: %s', $userSession->UserId);

		$this->DeleteLoginCookie($userSession->UserId);
		ServiceLocator::GetServer()->SetSession(SessionKeys::USER_SESSION, null);

		@session_unset();
		@session_destroy();
	}

	public function CookieLogin($cookieValue)
	{
		$loginCookie = LoginCookie::FromValue($cookieValue);
		$valid = false;

		if (!is_null($loginCookie))
		{
			$validEmail = $this->ValidateCookie($loginCookie);
			$valid = !is_null($validEmail);

			if ($valid)
			{
				$this->Login($validEmail, true);
			}
		}

		return $valid;
	}

	public function AreCredentialsKnown()
	{
		return false;
	}

	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		$loginPage->setShowLoginError();
	}

	private function IsAdminRole($userId, $emailAddress)
	{
		return $this->authorizationService->IsApplicationAdministrator(new AuthorizationUser($userId, $emailAddress));
	}

	private function SetUserSession($row, $isAdminRole)
	{
		$user = new UserSession($row[ColumnNames::USER_ID]);
		$user->Email = $row[ColumnNames::EMAIL];
		$user->FirstName = $row[ColumnNames::FIRST_NAME];
		$user->LastName = $row[ColumnNames::LAST_NAME];
		$user->Timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->HomepageId = $row[ColumnNames::HOMEPAGE_ID];

		$isAdmin = ($user->Email == Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL)) || (bool)$isAdminRole;
		$user->IsAdmin = $isAdmin;

		ServiceLocator::GetServer()->SetUserSession($user);
	}

	private function SetLoginCookie($userid, $lastLogin)
	{
		$cookie = new LoginCookie($userid, $lastLogin);
		ServiceLocator::GetServer()->SetCookie($cookie);
	}

	private function DeleteLoginCookie($userid)
	{
		$cookie = new LoginCookie($userid, null);
		ServiceLocator::GetServer()->SetCookie($cookie);
	}

	private function ValidateCookie($loginCookie)
	{
		$valid = false;
		$reader = ServiceLocator::GetDatabase()->Query(new CookieLoginCommand($loginCookie->UserID));

		if ($row = $reader->GetRow())
		{
			$valid = $row[ColumnNames::LAST_LOGIN] == $loginCookie->LastLogin;
		}

		return $valid ? $row[ColumnNames::EMAIL] : null;
	}
}
?>