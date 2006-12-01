<?php
//$dir = dirname(__FILE__) . '/../..';
//require_once($dir . '/lib/Database/namespace.php');
require_once('namespace.php');

class ISqlCommand
{
	function SetParameters(&$parameters) { die('Not implemented'); }
	function AddParameter(&$parameter) { die('Not implemented'); }
	function GetQuery() { die('Not implemented'); }
}
?>