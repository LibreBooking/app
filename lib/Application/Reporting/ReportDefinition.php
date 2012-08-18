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


class ChartType
{
	const Label = 'label';
	const Total = 'total';
	const TotalTime = 'totalTime';
	const Date = 'date';
}

class ReportCell
{
	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var null|string
	 */
	private $chartValue;

	/**
	 * @var ChartType|string|null
	 */
	private $chartType;

	/**
	 * @param string $value
	 * @param string|null $chartValue
	 * @param ChartType|string|null $chartType
	 */
	public function __construct($value, $chartValue = null, $chartType = null)
	{
		$this->value = $value;
		$this->chartValue = $chartValue;
		$this->chartType = $chartType;
	}

	public function Value()
	{
		return $this->value;
	}

	public function ChartValue()
	{
		return $this->chartValue;
	}

	public function ChartType()
	{
		return $this->chartType;
	}

	public function __toString()
	{
		return $this->Value();
	}
}

abstract class ReportColumn
{
	/**
	 * @var string
	 */
	private $titleKey;

	/**
	 * @var ChartType|null|string
	 */
	private $chartType;

	/**
	 * @param $titleKey string
	 * @param $chartType ChartType|string|null
	 */
	public function __construct($titleKey, $chartType = null)
	{
		$this->titleKey = $titleKey;
		$this->chartType = $chartType;
	}

	/**
	 * @return string
	 */
	public function TitleKey()
	{
		return $this->titleKey;
	}

	/**
	 * @param $data mixed
	 * @return string
	 */
	public function GetData($data)
	{
		return $data;
	}

	/**
	 * @return ChartType|string|null
	 */
	public function GetChartType()
	{
		return $this->chartType;
	}

	/**
	 * @param $data mixed
	 * @return string
	 */
	public function GetChartData($data)
	{
		return $data;
	}
}

class ReportStringColumn extends ReportColumn
{
	public function __construct($titleKey, $chartType = null)
	{
		parent::__construct($titleKey, $chartType);
	}
}

class ReportDateColumn extends ReportColumn
{
	private $timezone;
	private $format;

	public function __construct($titleKey, $timezone, $format, $chartType = null)
	{
		parent::__construct($titleKey, $chartType);
		$this->timezone = $timezone;
		$this->format = $format;
	}

	public function GetData($data)
	{
		return Date::FromDatabase($data)->ToTimezone($this->timezone)->Format($this->format);
	}
}

class ReportTimeColumn extends ReportColumn
{
	public function __construct($titleKey, $chartType = null)
	{
		parent::__construct($titleKey, $chartType);
	}

	public function GetData($data)
	{
		return new TimeInterval($data);
	}

	public function GetChartData($data)
	{
		return $data;
	}
}

interface IReportDefinition
{
	/**
	 * @return array|ReportColumn
	 */
	public function GetColumnHeaders();

	/**
	 * @abstract
	 * @param array $row
	 * @return ReportCell[]|array
	 */
	public function GetRow($row);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetTotal();

	/**
	 * @abstract
	 * @return string|ChartType
	 */
	public function GetChartType();
}

class ReportDefinition implements IReportDefinition
{
	/**
	 * @var array|ReportColumn[]
	 */
	private $columns = array();

	/**
	 * @var int
	 */
	private $sum = 0;

	/**
	 * @var ReportColumn
	 */
	private $sumColumn;

	public function __construct(IReport $report, $timezone)
	{
		$dateFormat = Resources::GetInstance()->GeneralDateTimeFormat();
		$orderedColumns = array(
			ColumnNames::ACCESSORY_NAME => new ReportStringColumn('Accessory', ChartType::Label),
			ColumnNames::RESOURCE_NAME_ALIAS => new ReportStringColumn('Resource', ChartType::Label),
			ColumnNames::QUANTITY => new ReportStringColumn('QuantityReserved'),
			ColumnNames::RESERVATION_START => new ReportDateColumn('BeginDate', $timezone, $dateFormat, ChartType::Date),
			ColumnNames::RESERVATION_END => new ReportDateColumn('EndDate', $timezone, $dateFormat),
			ColumnNames::RESERVATION_TITLE => new ReportStringColumn('Title'),
			ColumnNames::RESERVATION_DESCRIPTION => new ReportStringColumn('Description'),
			ColumnNames::REFERENCE_NUMBER => new ReportStringColumn('ReferenceNumber'),
			ColumnNames::OWNER_FULL_NAME_ALIAS => new ReportStringColumn('User', ChartType::Label),
			ColumnNames::GROUP_NAME_ALIAS => new ReportStringColumn('Group', ChartType::Label),
			ColumnNames::SCHEDULE_NAME_ALIAS => new ReportStringColumn('Schedule', ChartType::Label),
			ColumnNames::RESERVATION_CREATED => new ReportDateColumn('Created', $timezone, $dateFormat),
			ColumnNames::RESERVATION_MODIFIED => new ReportDateColumn('LastModified', $timezone, $dateFormat),
			ColumnNames::TOTAL => new ReportStringColumn('Total', ChartType::Total),
			ColumnNames::TOTAL_TIME => new ReportTimeColumn('Total', ChartType::Total),
		);

		$reportColumns = $report->GetColumns();

		foreach ($orderedColumns as $key => $column)
		{
			if ($reportColumns->Exists($key))
			{
				$this->columns[$key] = $column;
			}
		}
	}

	public function GetColumnHeaders()
	{
		return $this->columns;
	}

	public function GetRow($row)
	{
		$formattedRow = array();
		foreach ($this->columns as $key => $column)
		{
			if ($key == ColumnNames::TOTAL || $key == ColumnNames::TOTAL_TIME)
			{
				$this->sum += $row[$key];
				$this->sumColumn = $column;
			}
			$formattedRow[] = new ReportCell($column->GetData($row[$key]), $column->GetChartData($row[$key]), $column->GetChartType());
		}

		return $formattedRow;
	}

	public function GetTotal()
	{
		if ($this->sum > 0)
		{
			return $this->sumColumn->GetData($this->sum);
		}
		return '';
	}

	/**
	 * @return string|ChartType
	 */
	public function GetChartType()
	{
		if (array_key_exists(ColumnNames::TOTAL, $this->columns))
		{
			return ChartType::Total;
		}
		else if(array_key_exists(ColumnNames::TOTAL_TIME, $this->columns))
		{
			return ChartType::TotalTime;
		}

		return ChartType::Date;
	}
}

?>