<?php
require_once('namespace.php');

class IDbConnection
{
	/**
	* To be implemented by child
	*/
	function Connect() { die('Not implemented'); }
	
	/**
	* To be implemented by child
	*/
	function Disconnect() { die('Not implemented'); }

	/**
	* To be implemented by child
	* @param Command $command the database Command object to use for the query
	* @return IReader
	*/
	function &Query(&$command) { die('Not implemented'); } 
	
	/**
	* To be implemented by child
	* @param Command $command the database Command object to use for the query
	*/
	function Execute(&$command) { die('Not implemented'); }
}
?>