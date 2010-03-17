<?php
class MySqlCommandAdapter
{
	private $_values = null;
	private $_query = null;
	
	public function __construct(ISqlCommand &$command) 
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
	
	private function Convert(ISqlCommand &$command) 
	{		
		$query = $command->GetQuery();
		
		for ($p = 0; $p < $command->Parameters->Count(); $p++) 
		{
			$curParam = $command->Parameters->Items($p);
			
			$escapedValue = mysql_real_escape_string($curParam->Value);
			$query = str_replace($curParam->Name, "'$escapedValue'", $query);
		}
		
		$this->_query = $query . ';';
	}
}
?>