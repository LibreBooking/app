<?php
$dir = dirname(__FILE__) . '/../../..';
require_once($dir . '/lib/Database/SqlCommand.php');
require_once('DataConstant.php');

class AuthorizationCommand extends SqlCommand
{
	public function __construct($username, $password)
	{
		parent::__construct(Queries::VALIDATE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, strtolower($username)));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));		
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
?>