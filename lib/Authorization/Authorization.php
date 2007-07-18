<?php
require_once('namespace.php');
require_once(dirname(__FILE__) . '/../../lib/Database/Commands/namespace.php');

class Authorization implements IAuthorization 
{
	private $db;
	private $server;
	
	public function __construct(Database &$database, Server &$server)
	{
		$this->db = &$database;
		$this->server = &$server;
	}
	
	public function Validate($username, $password)
	{
		$command = new AuthorizationCommand($username, $password);
		$reader = $this->db->Query($command);
		return $reader->NumRows() > 0;
	}
	
	public function Login($username, $persist)
	{
		$command = new LoginCommand($username);
		$reader = $this->db->Query($command);
		
		if (($row = $reader->GetRow()) !== false)
		{
			$userid = $row[ColumnNames::USER_ID];
			$command = new UpdateLoginTimeCommand($userid, LoginTime::Now());
			//$this->db->Execute($command);
			
			$this->SetUserSession($row);
		}		
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
		
		$this->server->SetSession(SessionKeys::USER_SESSION, $user);
	}
}
?>