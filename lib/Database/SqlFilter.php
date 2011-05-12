<?php
interface ISqlFilter
{
	public function Criteria();
	public function _And(ISqlFilter $filter);
	public function _Or(ISqlFilter $filter);

	public function Where();
}

abstract class BaseSqlFilter implements ISqlFilter
{
	protected $criteria;
	private $_and = array();
	private $_or = array();

	/**
	 * @param string $columnName
	 * @param string $columnValue
	 */
	public function __construct($columnName, $columnValue)
	{
		$this->criteria = $this->GetCriteria($columnName, $columnValue);
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

class EqualsSqlFilter extends BaseSqlFilter
{
	protected function GetSql()
	{
		return "{$this->criteria->Name} = {$this->criteria->Variable}";
	}
}

class LikeSqlFilter extends BaseSqlFilter
{
	protected function GetSql()
	{
		return "{$this->criteria->Name} LIKE {$this->criteria->Variable}";
	}

	protected function GetCriteria($columnName, $columnValue)
	{
		return new Criteria($columnName, $columnValue . '%');
	}
}
?>