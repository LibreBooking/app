<?php
/**
Copyright 2012 Nick Korbel

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

class Report_Usage
{
	const RESOURCES = 'RESOURCES';
	const ACCESSORIES = 'ACCESSORIES';

	/**
	 * @var Report_Usage|string
	 */
	private $usage;

	/**
	 * @param $usage string|Report_Usage
	 */
	public function __construct($usage)
	{
		$this->usage = $usage;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->usage == self::ACCESSORIES)
		{
			$builder->OfAccessories();
		}
		else
		{
			$builder->OfResources();
		}
	}
}

class Report_ResultSelection
{
	const COUNT = 'COUNT';
	const TIME = 'TIME';
	const FULL_LIST = 'LIST';

	/**
	 * @var Report_ResultSelection|string
	 */
	private $selection;

	/**
	 * @param $selection string|Report_ResultSelection
	 */
	public function __construct($selection)
	{
		$this->selection = $selection;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->selection == self::FULL_LIST)
		{
			$builder->SelectFullList();
		}
		if ($this->selection == self::COUNT)
		{
			$builder->SelectCount();
		}
		if ($this->selection == self::TIME)
		{
			$builder->SelectTime();
		}
	}

	/**
	 * @param $selection string
	 * @return bool
	 */
	public function Equals($selection)
	{
		return $this->selection == $selection;
	}
}

class Report_GroupBy
{
	const NONE = 'NONE';
	const RESOURCE = 'RESOURCE';
	const SCHEDULE = 'SCHEDULE';
	const USER = 'USER';
	const GROUP = 'GROUP';

	/**
	 * @var Report_GroupBy|string
	 */
	private $groupBy;

	/**
	 * @param $groupBy string|Report_GroupBy
	 */
	public function __construct($groupBy)
	{
		$this->groupBy = $groupBy;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->groupBy == self::GROUP)
		{
			$builder->GroupByGroup();
		}
		if ($this->groupBy == self::SCHEDULE)
		{
			$builder->GroupBySchedule();
		}
		if ($this->groupBy == self::USER)
		{
			$builder->GroupByUser();
		}
		if ($this->groupBy == self::RESOURCE)
		{
			$builder->GroupByResource();
		}
	}
}

class Report_Range
{
	const DATE_RANGE = 'DATE_RANGE';
	const ALL_TIME = 'ALL_TIME';

	/**
	 * @var Report_Range|string
	 */
	private $range;

	/**
	 * @var Date
	 */
	private $start;

	/**
	 * @var Date
	 */
	private $end;

	/**
	 * @param $range string|Report_Range
	 * @param Date $start
	 * @param Date $end
	 */
	public function __construct($range, Date $start, Date $end)
	{
		$this->range = $range;
		$this->start = $start;
		$this->end = $end;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->range == self::DATE_RANGE)
		{
			$builder->Within($this->start, $this->end);
		}
	}
}

class Report_Filter
{
	/**
	 * @var int|null
	 */
	private $resourceId;

	/**
	 * @var int|null
	 */
	private $scheduleId;

	/**
	 * @var int|null
	 */
	private $userId;

	/**
	 * @var int|null
	 */
	private $groupId;

	/**
	 * @param $resourceId int|null
	 * @param $scheduleId int|null
	 * @param $userId int|null
	 * @param $groupId int|null
	 */
	public function __construct($resourceId, $scheduleId, $userId, $groupId)
	{
		$this->resourceId = $resourceId;
		$this->scheduleId = $scheduleId;
		$this->userId = $userId;
		$this->groupId = $groupId;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if (!empty($this->resourceId))
		{
			$builder->WithResourceId($this->resourceId);
		}
		if (!empty($this->scheduleId))
		{
			$builder->WithScheduleId($this->scheduleId);
		}
		if (!empty($this->userId))
		{
			$builder->WithUserId($this->userId);
		}
		if (!empty($this->groupId))
		{
			$builder->WithGroupId($this->groupId);
		}
	}
}

class ReportColumns implements IReportColumns
{
	private $allColumns = array(ColumnNames::TOTAL,
								ColumnNames::RESERVATION_CREATED,
								ColumnNames::RESERVATION_MODIFIED,
								ColumnNames::REPEAT_TYPE,
								ColumnNames::RESERVATION_DESCRIPTION,
								ColumnNames::RESERVATION_TITLE,
								ColumnNames::RESERVATION_STATUS,
								ColumnNames::REFERENCE_NUMBER,
								ColumnNames::RESERVATION_START,
								ColumnNames::RESERVATION_END,
								ColumnNames::RESOURCE_NAME_ALIAS,
								ColumnNames::RESOURCE_ID,
								ColumnNames::SCHEDULE_ID,
								ColumnNames::SCHEDULE_NAME_ALIAS,
								ColumnNames::OWNER_FIRST_NAME,
								ColumnNames::OWNER_LAST_NAME,
								ColumnNames::OWNER_USER_ID,
								ColumnNames::GROUP_NAME_ALIAS,
								ColumnNames::GROUP_ID,
								ColumnNames::ACCESSORY_ID,
								ColumnNames::ACCESSORY_NAME,
	);

	private $knownColumns = array();

	/**
	 * @param $columnName string
	 */
	public function Add($columnName)
	{
		if (in_array($columnName, $this->allColumns))
		{
			$this->knownColumns[] = $columnName;
		}
	}

	public function Exists($columnName)
	{
		return in_array($columnName, $this->knownColumns);
	}

	/**
	 * @return array|string
	 */
	public function GetAll()
	{
		return $this->knownColumns;
	}
}

interface IReportColumns
{
	/**
	 * @param $columnName string
	 * @return bool
	 */
	public function Exists($columnName);

	/**
	 * @abstract
	 * @return array|string
	 */
	public function GetAll();
}

interface IReportData
{
	/**
	 * @abstract
	 * @return array
	 */
	public function Rows();
}

class CustomReportData implements IReportData
{
	private $rows;

	public function __construct($rows)
	{
		$this->rows = $rows;
	}

	public function Rows()
	{
		return $this->rows;
	}
}

interface IReport
{
	/**
	 * @abstract
	 * @return IReportColumns
	 */
	public function GetColumns();

	/**
	 * @abstract
	 * @return IReportData
	 */
	public function GetData();

	/**
	 * @abstract
	 * @return int
	 */
	public function ResultCount();
}

interface IReportingService
{
	/**
	 * @abstract
	 * @param Report_Usage $usage
	 * @param Report_ResultSelection $selection
	 * @param Report_GroupBy $groupBy
	 * @param Report_Range $range
	 * @param Report_Filter $filter
	 * @return IReport
	 */
	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);
}

class CustomReport implements IReport
{
	/**
	 * @var CustomReportData
	 */
	private $data;
	/**
	 * @var ReportColumns
	 */
	private $cols;
	/**
	 * @var int
	 */
	private $resultCount = 0;

	public function __construct($rows)
	{
		$this->data = new CustomReportData($rows);
		$this->resultCount = count($rows);

		$this->cols = new ReportColumns();
		if (count($rows) > 0)
		{
			foreach ($rows[0] as $columnName => $value)
			{
				$this->cols->Add($columnName);
			}
		}
	}

	/**
	 * @return IReportColumns
	 */
	public function GetColumns()
	{
		return $this->cols;
	}

	/**
	 * @return IReportData
	 */
	public function GetData()
	{
		return $this->data;
	}

	/**
	 * @return int
	 */
	public function ResultCount()
	{
		return $this->resultCount;
	}
}

class ReportingService implements IReportingService
{
	/**
	 * @var IReportingRepository
	 */
	private $repository;

	public function __construct(IReportingRepository $repository)
	{
		$this->repository = $repository;
	}

	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$builder = new ReportCommandBuilder();

		$selection->Add($builder);
		if ($selection->Equals(Report_ResultSelection::FULL_LIST))
		{
			$usage->Add($builder);
		}
		$groupBy->Add($builder);
		$range->Add($builder);
		$filter->Add($builder);

		$data = $this->repository->GetCustomReport($builder);
		return new CustomReport($data);
	}
}

?>