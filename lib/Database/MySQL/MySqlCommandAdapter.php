<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class MySqlCommandAdapter
{
	private $_values = null;
	private $_query = null;
	private $_db = null;

	public function __construct(ISqlCommand &$command, $db)
	{
		$this->_values = array();
		$this->_query = null;
		$this->_db = $db;

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
					$escapedValues[] = mysqli_real_escape_string($this->_db, $value);
				}
				$values = implode("','", $escapedValues);
				$inClause = "'$values'";
				$query = str_replace($curParam->Name, $inClause, $query);
			}
			else
			{
				$escapedValue = mysqli_real_escape_string($this->_db, $curParam->Value);
				$query = str_replace($curParam->Name, "'$escapedValue'", $query);
			}
		}

		$this->_query = $query . ';';
	}
}
?>