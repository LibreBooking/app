<?php
class Database
{
	public $Connection = null;

	public function __construct(IDbConnection &$dbConnection) 
	{
		$this->Connection = &$dbConnection;
	}
	
	/**
	 * Queries the database and returns an IReader
	 *
	 * @param SqlCommand $command
	 * @return IReader to iterate over
	 */
	public function &Query(ISqlCommand &$command) 
	{
		$this->Connection->Connect();	
		$reader = $this->Connection->Query($command);
		$this->Connection->Disconnect();

		return $reader;
	}
	
	/**
	 * Executes an alter query against the database
	 *
	 * @param SqlCommand $command
	 * @return void
	 */
	public function Execute(ISqlCommand &$command) 
	{
		$this->Connection->Connect();	
		$this->Connection->Execute($command);
		$this->Connection->Disconnect();
	}
	
	/**
	 * Executes an alter query against the database and returns the auto-increment id
	 *
	 * @param SqlCommand $command
	 * @return long last id inserted for this connection
	 */
	public function ExecuteInsert(ISqlCommand &$command)
	{
		$this->Connection->Connect();	
		$this->Connection->Execute($command);
		$insertedId = $this->Connection->GetLastInsertId();
		$this->Connection->Disconnect();
		
		return $insertedId;
	}
}

?>