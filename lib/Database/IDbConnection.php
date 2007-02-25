<?php
require_once('namespace.php');

interface IDbConnection
{
	/**
	 * Connect to the database
	 */
	public function Connect();
	
	/**
	 * Disconnect from the database
	 */
	public function Disconnect();

	/**
	 * @param Command $command the database Command object to use for the query
	 * @return IReader
	 */
	public function &Query(&$command);
	
	/**
	 * @param Command $command the database Command object to use for the query
	 */
	public function Execute(&$command);
}
?>