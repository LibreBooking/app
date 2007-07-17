<?php
require_once('namespace.php');

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
	public function &Query(&$command);
	
	/**
	 * Executes an alter query against the database
	 *
	 * @param SqlCommand $command
	 * @return none
	 */
	public function Execute(&$command);
}
?>