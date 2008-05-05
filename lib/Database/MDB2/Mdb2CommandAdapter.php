<?php
class Mdb2CommandAdapter
{
	private $_values = null;
	private $_query = null;
	
	public function __construct(&$command) 
	{
		$_values = array();
		$_query = null;
		
		$this->Convert($command);
	}
	
	public function GetValues() 
	{
		return $this->_values;
	}
	
	public function GetQuery() 
	{
		return $this->_query;
	}
	
	private function Convert(&$command) 
	{		
		for ($p = 0; $p < $command->Parameters->Count(); $p++) 
		{
			$curParam = $command->Parameters->Items($p);
			$this->_values[str_replace('@', '', $curParam->Name)] = $curParam->Value;
		}
		
		$this->_query = str_replace('@', ':', $command->GetQuery());
	}
}
?>