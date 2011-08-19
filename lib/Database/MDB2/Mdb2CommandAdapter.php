<?php
class Mdb2CommandAdapter
{
	private $_values = null;
	private $_query = null;
	
	public function __construct(&$command) 
	{
		$this->_values = array();
		$this->_query = null;
		
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
	
	private function Convert(SqlCommand $command)
	{		
		for ($p = 0; $p < $command->Parameters->Count(); $p++) 
		{
			$curParam = $command->Parameters->Items($p);

			$value = $curParam->Value;
			if (is_array($value))
			{
				$value = implode("','", $value);
				$value = "'$value'";
			}
			
			$this->_values[str_replace('@', '', $curParam->Name)] = $value;
		}
		
		$this->_query = str_replace('@', ':', $command->GetQuery());
	}
}
?>