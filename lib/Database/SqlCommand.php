<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Database/ISqlCommand.php');
require_once(ROOT_DIR . 'lib/Database/SqlFilter.php');

class SqlCommand implements ISqlCommand
{
	public $Parameters = null;
		
	private $_paramNames = array();
	private $_values = array();
	private $_query = null;
	
	public function __construct($query = null) 
	{
		$this->_query = $query;
		$this->Parameters = new Parameters();
	}
	
	public function SetParameters(Parameters &$parameters) 
	{
		$this->_paramNames = array();	// Clean out contents
		$this->_values = array();
		
		$this->Parameters = &$parameters;
		
		for ($i = 0; $i < $this->Parameters->Count(); $i++) 
		{
			$p = $this->Parameters->Items($i);
			$this->_paramNames[] = $p->Name;
			$this->_values[] = $p->Value;
		}
	}
	
	public function AddParameter(Parameter &$parameter) 
	{
		$this->Parameters->Add($parameter);
	}

	public function GetQuery() 
	{
		return $this->_query;
	}
	
	public function ToString()
	{
		$builder = new StringBuilder();
		$builder->append("Command: {$this->_query}\n");
		$builder->append("Parameters ({$this->Parameters->Count()}): \n");
		
		for($i = 0; $i < $this->Parameters->Count(); $i++)
		{
			$parameter = $this->Parameters->Items($i);
			$builder->append("{$parameter->Name} = {$parameter->Value}");	
		}
		
		return $builder->toString();
	}
	
	public function __toString()
	{
		return $this->ToString();
	}
}

class AdHocCommand extends SqlCommand
{
	public function __construct($rawSql)
	{
		parent::__construct($rawSql);
	}
}

class CountCommand extends SqlCommand
{
	/**
	 * @var SqlCommand
	 */
	private $baseCommand;

	public function __construct(SqlCommand $baseCommand)
	{
		parent::__construct();

		$this->baseCommand = $baseCommand;
		$this->Parameters = $baseCommand->Parameters;
	}

	public function GetQuery()
	{
		return preg_replace('/SELECT.+FROM/imsU', 'SELECT COUNT(*) as total FROM', $this->baseCommand->GetQuery(), 1);
	}
}

class FilterCommand extends SqlCommand
{
	/**
	 * @var SqlCommand
	 */
	private $baseCommand;

	/**
	 * @var \ISqlFilter
	 */
	private $filter;

	public function __construct(SqlCommand $baseCommand, ISqlFilter $filter)
	{
		$this->baseCommand = $baseCommand;
		$this->filter = $filter;

		$this->Parameters = $baseCommand->Parameters;
		$criterion = $filter->Criteria();
		/** @var $criteria Criteria */
		foreach ($criterion as $criteria)
		{
			$this->AddParameter(new Parameter($criteria->Variable, $criteria->Value));
		}
	}

	public function GetQuery()
	{
		$baseQuery = $this->baseCommand->GetQuery();
		$query = $baseQuery;
		$hasWhere = (stripos($baseQuery, 'WHERE') !== false);
		$hasOrderBy = (stripos($baseQuery, 'ORDER BY') !== false);
		$newWhere = $this->filter->Where();

		//Log::Debug("Applying filter to base query: $baseQuery");
		if ($hasWhere)
		{
			// get between where and order by, replace with match plus new stuff
			$baseQuery = preg_replace('/WHERE/ims', 'WHERE (', $baseQuery, 1);

			//Log::Debug("HAS WHERE, adding filter $newWhere");
			$split = preg_split("/ORDER BY/ims", $baseQuery);

			if (count($split) > 1)
			{
				$query = "{$split[0]}) AND ($newWhere) ORDER BY {$split[1]}";
			}
			else
			{
				$query = "$baseQuery) AND ($newWhere)";
			}
		}
		else if (!$hasWhere && $hasOrderBy)
		{
			//Log::Debug("ORDER BY, adding filter $newWhere");
			// replace order by, prefixing where
			$query = str_ireplace('order by', " WHERE $newWhere ORDER BY", $baseQuery);
		}
		else
		{
			//Log::Debug("NO WHERE, adding filter $newWhere");
			// no where, no order by, just append new where clause
			$query = "$baseQuery WHERE $newWhere";
		}
	
		return $query;
	}
}
?>