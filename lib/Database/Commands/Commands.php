<?php
require_once('/lib/Database/SqlCommand.php');
require_once('/lib/Database/Commands/DataConstant.php');

class AuthorizationCommand extends SqlCommand
{
	function AuthorizationCommand($username, $password)
	{
		$queries = new Queries();
		$params = new ParameterNames();
		
		parent::SqlCommand($queries->VALIDATE_USER);
		$this->AddParameter(new Parameter($params->USER_NAME, $username));
		$this->AddParameter(new Parameter($params->PASSWORD, $password));		
	}
}
?>