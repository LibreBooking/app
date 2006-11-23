<?php
require_once('/lib/Database/namespace.php');

class ISqlCommand
{
	function SetParameters(&$parameters) { die('Not implemented'); }
	function AddParameter(&$parameter) { die('Not implemented'); }
	function GetQuery() { die('Not implemented'); }
}
?>