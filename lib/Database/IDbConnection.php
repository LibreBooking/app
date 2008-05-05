<?php
interface IDbConnection
{
	public function Connect();
	public function Disconnect();
	
	/**
	 * Queries the database and returns an IReader
	 *
	 * @param SqlCommand $command
	 * @return IReader to iterate over
	 */
	public function Query(&$command);
	
	/**
	 * Executes an alter query against the database
	 *
	 * @param SqlCommand $command
	 * @return void
	 */
	public function Execute(&$command);
	
	/**
	 * @return long last auto-increment id inserted for this connection
	 */
	public function GetLastInsertId();
}
?>