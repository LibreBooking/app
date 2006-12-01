<?php
$dir = dirname(__FILE__) . '/../../..';
require_once($dir . '/lib/Database/SqlCommand.php');
require_once('DataConstant.php');

class AuthorizationCommand extends SqlCommand
{
	function AuthorizationCommand($username, $password)
	{
		$queries = new Queries();
		$params = new ParameterNames();
		
		parent::SqlCommand($queries->VALIDATE_USER);
		$this->AddParameter(new Parameter($params->USER_NAME, strtolower($username)));
		$this->AddParameter(new Parameter($params->PASSWORD, $password));		
	}
}

class LoginCommand extends SqlCommand
{
	function LoginCommand($username)
	{
		$queries = new Queries();
		$params = new ParameterNames();
		
		parent::SqlCommand($queries->LOGIN_USER);
		$this->AddParameter(new Parameter($params->USER_NAME, strtolower($username)));		
	}
}

class UpdateLoginTimeCommand extends SqlCommand
{
	function UpdateLoginTimeCommand($userid, $lastlogin)
	{
		$queries = new Queries();
		$params = new ParameterNames();
		
		parent::SqlCommand($queries->UPDATE_LOGINTIME);
		$this->AddParameter(new Parameter($params->LAST_LOGIN, $lastlogin));
		$this->AddParameter(new Parameter($params->USER_ID, $userid));		
	}
}
?>