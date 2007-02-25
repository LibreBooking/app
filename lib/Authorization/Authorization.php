<?php
require_once('namespace.php');
require_once(dirname(__FILE__) . '/../../lib/Database/Commands/namespace.php');

class Authorization implements IAuthorization 
{
	private $_db;
	private $_server;
	
	public function __construct(&$database, &$server)
	{
		$this->_db = &$database;
		$this->_server = &$server;
	}
	
	public function Validate($username, $password)
	{
		$command = new AuthorizationCommand($username, $password);
		$reader = $this->_db->Query($command);
		return $reader->NumRows() > 0;
	}
	
	public function Login($username, $persist)
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
			
			$this->setUserSession($row);
		}		
	}
	
	private function setUserSession($row)
	{
		$names = new ColumnNames();
		$ckeys = new ConfigKeys();
		$skeys = new SessionKeys();
		$config = new Configuration();
		
		$user = new UserSession($row[$names->USER_ID]);
		$user->Email = $row[$names->EMAIL];
		$user->FirstName = $row[$names->FIRST_NAME];
		$user->LastName = $row[$names->LAST_NAME];
		
		$isAdmin = ($user->Email == $config->GetKey($ckeys->ADMIN_EMAIL)) || (bool)$row[$names->IS_ADMIN];
		$user->IsAdmin = $isAdmin;
		
		$tzOffset = intval($row[$names->TIMEZONE]) - intval($config->GetKey($ckeys->SERVER_TIMEZONE));
		$user->TimeOffset = $tzOffset;
		
		$this->_server->SetSession($skeys->USER_SESSION, $user);
	}
}
?>