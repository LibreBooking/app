<?php
require_once('/lib/Database/Commands/Commands.php');

class Authorization extends IAuthorization 
{
	var $_db;
	
	function Authorization(&$database)
	{
		$this->_db = &$database;
	}
	
	function Validate($username, $password)
	{
		$command = new AuthorizationCommand(strtolower($username), $password);
		$this->_db->Query($command);
	}
	
	function Login($username, $persist)
	{
		die( 'Not implemented' );
	}
}
?>