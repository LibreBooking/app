<?php
/**
Copyright 2011-2017 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

interface ISqlFilter
{
	public function Criteria();
	public function _And(ISqlFilter $filter);
	public function _Or(ISqlFilter $filter);

	public function Where();
}

interface ISqlFilterColumn
{
	/**
	 * @param mixed $columnValue
	 * @return Criteria
	 */
	public function GetCriteria($columnValue);
}

class SqlFilterColumn implements ISqlFilterColumn
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

	public function GetCriteria($columnValue)
	{
		return new Criteria($this->fullName, $columnValue);
	}
}

class SqlRepeatingFilterColumn implements ISqlFilterColumn
{
	private $fullName;
	private $index;

	public function __construct($tableName, $columnName, $index)
	{
		$this->fullName = empty($tableName) ? $columnName :  $tableName . '.' . $columnName;
		$this->index = $index;
	}

	public function GetCriteria($columnValue)
	{
		return new Criteria($this->fullName, $columnValue, "repeating{$this->index}{$this->fullName}");
	}
}

abstract class BaseSqlFilter implements ISqlFilter
{
	protected $criteria;
	private $_and = array();
	private $_or = array();

	/**
	 * @param string|ISqlFilterColumn $columnName
	 * @param string $columnValue
	 */
	public function __construct($columnName, $columnValue)
	{
		if (is_string($columnName))
		{
			$this->criteria = $this->GetCriteria($columnName, $columnValue);
		}
		else
		{
			$this->criteria = $columnName->GetCriteria($columnValue);
		}
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

		if (!empty($this->criteria))
		{
			array_unshift($criteria, $this->criteria);
		}

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
			$sql .= " AND ( {$filter->Where()} )";
		}

		/** @var $filter ISqlFilter */
		foreach ($this->_or as $filter)
		{
			$sql .= " OR ( {$filter->Where()} )";
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

	public function __construct($columnName, $columnValue, $variableName = null)
	{
		$this->Name = $columnName;
		$this->Value = $columnValue;
		$this->Variable = empty($variableName) ? "@$columnName" : "@$variableName";
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

class SqlFilterNotEquals extends BaseSqlFilter
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
		return "{$this->criteria->Name} != {$this->criteria->Variable}";
	}
}

class SqlFilterFreeForm extends BaseSqlFilter
{
	/**
	 * @var Criteria[]
	 */
	private $_criteria = array();
	private $sql = '';

	public function __construct($sql)
	{
		$this->sql  = $sql;
	}

	protected function GetSql()
	{
		return $this->sql;
	}

	public function Substitute($token, ISqlFilter $filter)
	{
		$this->sql = str_replace("[$token]", $filter->Where(), $this->sql);
		$this->_criteria = $filter->Criteria();
	}

	public function AppendSql($sql)
	{
		$this->sql .= $sql;
	}

	public function Criteria()
	{
		return $this->_criteria;
	}
}

class SqlFilterLike extends BaseSqlFilter
{
	/**
	 * @param string|ISqlFilterColumn $columnName
	 * @param string $columnValue
	 */
	public function __construct($columnName, $columnValue)
	{
		if (!BookedStringHelper::Contains($columnValue, '%'))
		{

			$columnValue = '%' . $columnValue . '%';
		}
		parent::__construct($columnName, $columnValue);
	}

	protected function GetSql()
	{
		return "{$this->criteria->Name} LIKE {$this->criteria->Variable}";
	}

	protected function GetCriteria($columnName, $columnValue)
	{
		return new Criteria($columnName, $columnValue);
	}
}

class SqlFilterGreaterThan extends BaseSqlFilter
{
	/**
	 * @var bool
	 */
	private $inclusive = false;

	/**
	 * @param string|ISqlFilterColumn $columnName
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
	 * @param string|ISqlFilterColumn $columnName
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
	 * @param string|ISqlFilterColumn $columnName
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
	/**
	 * @var bool
	 */
	private $defaultNegativeCondition;

	public function __construct($defaultNegativeCondition = false)
	{
		parent::__construct('1', '1');
		$this->criteria = null;
		$this->defaultNegativeCondition = $defaultNegativeCondition;
	}

	protected function GetSql()
	{
		return $this->defaultNegativeCondition ? '0=1' : '1=1';
	}
}