<?php
require_once('namespace.php');

class Database
{
	var $Connection = null;

	function Database(&$dbConnection) {
		$this->Connection = &$dbConnection;
	}
	
	function &Query(&$command) {
		$this->Connection->Connect();		
		$reader = $this->Connection->Query($command);
		$this->Connection->Disconnect();
		
		return $reader;
	}
	
	function Execute(&$command) {
		$this->Connection->Connect();		
		$this->Connection->Execute($command);
		$this->Connection->Disconnect();
	}
}

?>