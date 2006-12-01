<?php
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
		$names = new ColumnNames();
		
		$command = new LoginCommand($username);
		$reader = $this->_db->Query($command);
		
		if(($row = $reader->GetRow()) !== false)
		{
			$time = new LoginTime();
			$userid = $row[$names->USER_ID];
			$command = new UpdateLoginTimeCommand($userid, $time->Now());
			$this->_db->Execute($command);
		}		
	}
}
?>