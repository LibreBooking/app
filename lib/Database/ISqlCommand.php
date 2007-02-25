<?php
require_once('namespace.php');

interface ISqlCommand
{
	/**
	 * Sets the collection of Parameters for the Command
	 * @param Parameters $parameters
	 */
	public function SetParameters(Parameters &$parameters);
	
	/**
	 * Adds a Parameter to the Command
	 * @param Parameter $parameter
	 */
	public function AddParameter(Parameter &$parameter);
		
	/**
	 * @return The currently set Query for the Command
	 */
	public function GetQuery();
}
?>