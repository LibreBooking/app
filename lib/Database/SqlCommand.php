<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
		$this->_paramNames = array(); // Clean out contents
		$this->_values = array();

		$this->Parameters = & $parameters;

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

		for ($i = 0; $i < $this->Parameters->Count(); $i++)
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
		return 'SELECT COUNT(*) as total FROM (' . $this->baseCommand->GetQuery() . ') results';
//		return preg_replace('/SELECT.+FROM/imsU', 'SELECT COUNT(*) as total FROM', $this->baseCommand->GetQuery(), 1);
	}
}

class FilterCommand extends SqlCommand
{
	/**
	 * @var SqlCommand
	 */
	private $baseCommand;

	/**
	 * @var ISqlFilter
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
		$baseQueryUpper = strtoupper($baseQuery);
		$numberOfWheres = substr_count($baseQueryUpper, 'WHERE');
		$numberOfSelects = substr_count($baseQueryUpper, 'SELECT');
		$hasWhere = $numberOfWheres !== false && $numberOfWheres > 0 && $numberOfWheres == $numberOfSelects;

		$hasOrderBy = (stripos($baseQuery, 'ORDER BY') !== false);
		$hasGroupBy = (stripos($baseQuery, 'GROUP BY') !== false);

		$newWhere = $this->filter->Where();

		if ($hasWhere)
		{
			// get between where and order by, replace with match plus new stuff
			$pos = strripos($baseQuery, 'WHERE');
			$baseQuery = substr_replace($baseQuery, 'WHERE (', $pos, strlen('WHERE'));

			$groupBySplit = preg_split("/GROUP BY/ims", $baseQuery);
			$orderBySplit = preg_split("/ORDER BY/ims", $baseQuery);

			if (count($groupBySplit) > 1)
			{
				$queryFragment = trim($groupBySplit[0]);
				$groupBy = trim($groupBySplit[1]);
				$query = "$queryFragment ) AND ($newWhere) GROUP BY $groupBy";
			}
			elseif (count($orderBySplit) > 1)
			{
				$queryFragment = trim($orderBySplit[0]);
				$orderBy = trim($orderBySplit[1]);
				$query = "$queryFragment ) AND ($newWhere) ORDER BY $orderBy";
			}
			else
			{
				$query = "$baseQuery) AND ($newWhere)";
			}
		}
		else {
			if ($hasGroupBy)
			{
				$query = str_ireplace('group by', " WHERE $newWhere GROUP BY", $baseQuery);
			}
			elseif ($hasOrderBy)
			{
				$query = str_ireplace('order by', " WHERE $newWhere ORDER BY", $baseQuery);
			}
			else
			{
				// no where, no order by, just append new where clause
				$query = "$baseQuery WHERE $newWhere";
			}
		}

		return $query;
	}
}