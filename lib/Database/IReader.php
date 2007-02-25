<?php
require_once('namespace.php');

interface IReader
{
	public function &GetRow();
	
	public function NumRows();
	
	public function Free();
}

?>