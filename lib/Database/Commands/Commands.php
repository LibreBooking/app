<?php
$dir = dirname(__FILE__) . '/../../..';
require_once($dir . '/lib/Database/SqlCommand.php');
require_once('DataConstant.php');

class AuthorizationCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::VALIDATE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, strtolower($username)));	
	}
}

class LoginCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::LOGIN_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, strtolower($username)));		
	}
}

class UpdateLoginTimeCommand extends SqlCommand
{
	public function __construct($userid, $lastlogin)
	{
		parent::__construct(Queries::UPDATE_LOGINTIME);
		$this->AddParameter(new Parameter(ParameterNames::LAST_LOGIN, $lastlogin));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));	
	}
}

class MigratePasswordCommand extends SqlCommand 
{
	public function __construct($userid, $password, $salt)
	{
		parent::__construct(Queries::MIGRATE_PASSWORD);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
	}
}
?>