<?php
require_once('namespace.php');
require_once(dirname(__FILE__) . '/../Common/namespace.php');
require_once(dirname(__FILE__) . '/../Database/Commands/namespace.php');

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
			$command = new UpdateLoginTimeCommand($userid, $loginTime);
			ServiceLocator::GetDatabase()->Execute($command);
			
			$this->SetUserSession($row);
			
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
	
	private function SetUserSession($row)
	{
		$user = new UserSession($row[ColumnNames::USER_ID]);
		$user->Email = $row[ColumnNames::EMAIL];
		$user->FirstName = $row[ColumnNames::FIRST_NAME];
		$user->LastName = $row[ColumnNames::LAST_NAME];
		
		$isAdmin = ($user->Email == Configuration::GetKey(ConfigKeys::ADMIN_EMAIL)) || (bool)$row[ColumnNames::IS_ADMIN];
		$user->IsAdmin = $isAdmin;
		
		$tzOffset = intval($row[ColumnNames::TIMEZONE]) - intval(Configuration::GetKey(ConfigKeys::SERVER_TIMEZONE));
		$user->TimeOffset = $tzOffset;
		
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