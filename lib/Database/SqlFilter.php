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

interface ISqlFilter
{
	public function Criteria();
	public function _And(ISqlFilter $filter);
	public function _Or(ISqlFilter $filter);

	public function Where();
}

class SqlFilterColumn
{
	private $fullName;
	
	public function __construct($tableName, $columnName)
	{
		$this->fullName = $tableName . '.' . $columnName;
	}

	public function __toString()
	{
		return $this->fullName;
	}
}

abstract class BaseSqlFilter implements ISqlFilter
{
	protected $criteria;
	private $_and = array();
	private $_or = array();

	/**
	 * @param string|SqlFilterColumn $columnName
	 * @param string $columnValue
	 */
	public function __construct($columnName, $columnValue)
	{
		if (is_a($columnName, 'SqlFilterColumn'))
		{
			$name = $columnName->__toString();
		}
		else
		{
			$name = $columnName;
		}
		$this->criteria = $this->GetCriteria($name, $columnValue);
	}

	/**
	 * @param string $columnName
	 * @param string $columnValue
	 * @return Criteria
	 */
	protected function GetCriteria($columnName, $columnValue)
	{
		return new Criteria($columnName, $columnValue);
	}

	public function Criteria()
	{
		$criteria = array();

		/** @var $filter ISqlFilter */
		foreach($this->_and as $filter)
		{
			foreach($filter->Criteria() as $c)
			{
				$criteria[] = $c;
			}
		}

		/** @var $filter ISqlFilter */
		foreach($this->_or as $filter)
		{
			foreach($filter->Criteria() as $c)
			{
				$criteria[] = $c;
			}
		}

		array_unshift($criteria, $this->criteria);

		return $criteria;
	}

	public function _And(ISqlFilter $filter)
	{
		$this->_and[] = $filter;
		return $this;
	}

	public function _Or(ISqlFilter $filter)
	{
		$this->_or[] = $filter;
		return $this;
	}

	public function Where()
	{
		$sql = $this->GetSql();

		/** @var $filter ISqlFilter */
		foreach ($this->_and as $filter)
		{
			$sql .= " AND {$filter->Where()}";
		}

		/** @var $filter ISqlFilter */
		foreach ($this->_or as $filter)
		{
			$sql .= " OR {$filter->Where()}";
		}

		return $sql;
	}

	protected abstract function GetSql();
}

class Criteria
{
	public $Name;
	public $Value;
	public $Variable;

	public function __construct($columnName, $columnValue)
	{
		$this->Name = $columnName;
		$this->Value = $columnValue;
		$this->Variable = '@' . $columnName;
	}
}

class SqlFilterEquals extends BaseSqlFilter
{
	/**
	 * @param string|SqlFilterColumn $columnName
	 * @param string $columnValue
	 */
	public function __construct($columnName, $columnValue)
	{
		parent::__construct($columnName, $columnValue);
	}
	
	protected function GetSql()
	{
		return "{$this->criteria->Name} = {$this->criteria->Variable}";
	}
}

class SqlFilterLike extends BaseSqlFilter
{
	/**
	 * @param string|SqlFilterColumn $columnName
	 * @param string $columnValue
	 */
	public function __construct($columnName, $columnValue)
	{
		parent::__construct($columnName, $columnValue);
	}
	
	protected function GetSql()
	{
		return "{$this->criteria->Name} LIKE {$this->criteria->Variable}";
	}

	protected function GetCriteria($columnName, $columnValue)
	{
		return new Criteria($columnName, $columnValue . '%');
	}
}

class SqlFilterGreaterThan extends BaseSqlFilter
{
	/**
	 * @var bool
	 */
	private $inclusive = false;
	
	/**
	 * @param string|SqlFilterColumn $columnName
	 * @param string $columnValue
	 * @param bool $inclusive false by default
	 */
	public function __construct($columnName, $columnValue, $inclusive = false)
	{
		$this->inclusive = $inclusive;
		parent::__construct($columnName, $columnValue);
	}
	
	protected function GetSql()
	{
		$sign = $this->inclusive ? '>=' : '>';
		return "{$this->criteria->Name} $sign {$this->criteria->Variable}";
	}
}

class SqlFilterLessThan extends BaseSqlFilter
{
	/**
	 * @var bool
	 */
	private $inclusive = false;

	/**
	 * @param string|SqlFilterColumn $columnName
	 * @param string $columnValue
	 * @param bool $inclusive false by default
	 */
	public function __construct($columnName, $columnValue, $inclusive = false)
	{
		$this->inclusive = $inclusive;
		parent::__construct($columnName, $columnValue);
	}

	protected function GetSql()
	{
		$sign = $this->inclusive ? '<=' : '<';
		return "{$this->criteria->Name} $sign {$this->criteria->Variable}";
	}
}

class SqlFilterIn extends BaseSqlFilter
{
	/**
	 * @var array
	 */
	private $possibleValues = array();

	/**
	 * @param string|SqlFilterColumn $columnName
	 * @param array $possibleValues
	 */
	public function __construct($columnName, $possibleValues)
	{
		$this->possibleValues = $possibleValues;
		parent::__construct($columnName, $columnName . 'In');
	}

	protected function GetSql()
	{
		$escapedValues = array();
		foreach ($this->possibleValues as $value)
		{
			$escapedValues[] = str_replace("'", "''", $value);
		}
		$values = implode("','", $escapedValues);
		$inClause = "'$values'";
		return "{$this->criteria->Name} IN ($inClause)";
	}
}

class SqlFilterNull extends BaseSqlFilter
{
	public function __construct()
	{
		parent::__construct('1', '1');
	}
	
	protected function GetSql()
	{
		return '1=1';
	}
}
?>