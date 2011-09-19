<?php
class MySqlCommandAdapter
{
	private $_values = null;
	private $_query = null;
	
	public function __construct(ISqlCommand &$command) 
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
	
	private function Convert(SqlCommand &$command)
	{		
		$query = $command->GetQuery();

		for ($p = 0; $p < $command->Parameters->Count(); $p++) 
		{
			$curParam = $command->Parameters->Items($p);
			
			if (is_null($curParam->Value))
			{
				$query = str_replace($curParam->Name, 'null', $query);
			}
			if  (is_array($curParam->Value))
			{
				$escapedValues = array();
				foreach ($curParam->Value as $value)
				{
					$escapedValues[] = mysql_real_escape_string($value);
				}
				$values = implode("','", $escapedValues);
				$inClause = "'$values'";
				$query = str_replace($curParam->Name, $inClause, $query);
			}
			else
			{
				$escapedValue = mysql_real_escape_string($curParam->Value);
				$query = str_replace($curParam->Name, "'$escapedValue'", $query);
			}
		}
		
		$this->_query = $query . ';';
	}
}
?>