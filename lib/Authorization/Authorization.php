<?php
//$dir = dirname(__FILE__) . '/../..';
//require_once($dir . '/lib/Authorization/namespace.php');
//require_once($dir . '/lib/Database/Commands/Commands.php');

require_once('namespace.php');
require_once(dirname(__FILE__) . '/../../lib/Database/Commands/namespace.php');

class Authorization extends IAuthorization 
{
	var $_db;
	
	function Authorization(&$database)
	{
		$this->_db = &$database;
	}
	
	function Validate($username, $password)
	{
		$command = new AuthorizationCommand($username, $password);
		$reader = $this->_db->Query($command);
		return $reader->NumRows() > 0;
	}
	
	function Login($username, $persist)
	{
		$command = new LoginCommand($username);
		$reader = $this->_db->Query($command);
	}
}
?>