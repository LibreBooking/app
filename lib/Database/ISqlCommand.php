<?php
//require_once('namespace.php');

interface ISqlCommand
{
	public function SetParameters(Parameters &$parameters);
	public function AddParameter(Parameter &$parameter);
	public function GetQuery();
}
?>