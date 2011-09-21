<?php
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
	 * @param string $columnName
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
	 * @param string $columnName
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
	 * @param string $columnName
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