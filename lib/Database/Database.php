<?php
require_once('namespace.php');

class Database
{
	public $Connection = null;

	public function __construct(IDbConnection &$dbConnection) 
	{
		$this->Connection = &$dbConnection;
	}
	
	public function &Query(ISqlCommand &$command) 
	{
		$this->Connection->Connect();		
		$reader = $this->Connection->Query($command);
		$this->Connection->Disconnect();
		
		return $reader;
	}
	
	public function Execute(ISqlCommand &$command) 
	{
		$this->Connection->Connect();		
		$this->Connection->Execute($command);
		$this->Connection->Disconnect();
	}
}

?>