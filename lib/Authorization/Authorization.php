<?php
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

class Authorization implements IAuthorization 
{	
	private $passwordMigration = null;
	
	public function __construct()
	{
	}
	
	public function SetMigration(PasswordMigration $migration)
	{
		$this->passwordMigration = $migration;
	}
	
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
		$command = new AuthorizationCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);		
		$valid = false;
		
		if ($row = $reader->GetRow())
		{
			$migration = $this->GetMigration();
			$password = $migration->Create($password, $row[ColumnNames::OLD_PASSWORD], $row[ColumnNames::PASSWORD]);
			
			$salt = $row[ColumnNames::SALT];
			
			if ($password->Validate($salt))
			{
				$password->Migrate($row[ColumnNames::USER_ID]);
				$valid = true;
			}
		}
		
		return $valid;
	}
	
	public function Login($username, $persist)
	{
		$command = new LoginCommand($username);
		$reader = ServiceLocator::GetDatabase()->Query($command);
		
		if ($row = $reader->GetRow())
		{
			$loginTime = LoginTime::Now();
			$userid = $row[ColumnNames::USER_ID];
			
			$isAdminRole = $this->IsAdminRole($userid);

			$updateLoginTimeCommand = new UpdateLoginTimeCommand($userid, $loginTime);
			ServiceLocator::GetDatabase()->Execute($updateLoginTimeCommand);
			
			$this->SetUserSession($row, $isAdminRole);
			
			if ($persist)
			{
				$this->SetLoginCookie($userid, $loginTime);
			}
		}	
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
	
	private function IsAdminRole($userid)
	{
		$isAdminRole = false;
		
		$command = new GetUserRoleCommand($userid);
		$reader = ServiceLocator::GetDatabase()->Query($command);
		
		if ($row = $reader->GetRow())
		{
			$isAdminRole = (bool)$row[ColumnNames::IS_ADMIN];
		}
		
		return $isAdminRole;
	}
	
	private function SetUserSession($row, $isAdminRole)
	{
		$user = new UserSession($row[ColumnNames::USER_ID]);
		$user->Email = $row[ColumnNames::EMAIL];
		$user->FirstName = $row[ColumnNames::FIRST_NAME];
		$user->LastName = $row[ColumnNames::LAST_NAME];
		
		$isAdmin = ($user->Email == Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL)) || (bool)$isAdminRole;
		$user->IsAdmin = $isAdmin;
		$user->Timezone = $row[ColumnNames::TIMEZONE_NAME];
		
		ServiceLocator::GetServer()->SetSession(SessionKeys::USER_SESSION, $user);
	}
	
	private function SetLoginCookie($userid, $lastLogin)
	{
		$cookie = new LoginCookie($userid, $lastLogin);
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