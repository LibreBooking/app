<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reporting/ChartColumnDefinition.php');

class ReportAttributeCell extends ReportCell
{
	private $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function Value()
	{
		return $this->value;
	}
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
	private $chartColumnType;

	/**
	 * @param string $value
	 * @param string|null $chartValue
	 * @param ChartColumnType|string|null $chartColumnType
	 * @param ChartGroup $chartGroup
	 */
	public function __construct($value, $chartValue = null, $chartColumnType = null, $chartGroup = null)
	{
		$this->value = $value;
		$this->chartValue = $chartValue;
		$this->chartColumnType = $chartColumnType;
		$this->chartGroup = $chartGroup;
	}

	public function Value()
	{
		return $this->value;
	}

	public function ChartValue()
	{
		return $this->chartValue;
	}

	public function GetChartColumnType()
	{
		return $this->chartColumnType;
	}

	public function GetChartGroup()
	{
		return $this->chartGroup;
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
	protected $titleKey;

	/**
	 * @var ChartColumnDefinition
	 */
	protected $chartColumnDefinition;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @param $titleKey string
	 * @param $chartColumnDefinition ChartColumnDefinition
	 */
	public function __construct($titleKey, ChartColumnDefinition $chartColumnDefinition = null)
	{
		$this->titleKey = $titleKey;
		$this->chartColumnDefinition = $chartColumnDefinition;
	}

	/**
	 * @return string
	 */
	public function TitleKey()
	{
		return $this->titleKey;
	}

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->title;
	}

	/**
	 * @return bool
	 */
	public function HasTitle()
	{
		return $this->title != null;
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
	 * @return ChartColumnType|string|null
	 */
	public function GetChartColumnType()
	{
		return $this->chartColumnDefinition->ChartColumnType();
	}

	/**
	 * @param $row array
	 * @param $columnKey string
	 * @return string
	 */
	public function GetChartData($row, $columnKey)
	{
		return $this->chartColumnDefinition->GetChartData($row, $columnKey);
	}

	/**
	 * @return ChartGroup|null|string
	 */
	public function GetChartGroup()
	{
		return $this->chartColumnDefinition->GetChartGroup();
	}
}

class ReportStringColumn extends ReportColumn
{
	public function __construct($title, ChartColumnDefinition $chartColumnDefinition)
	{
		parent::__construct(null, $chartColumnDefinition);
		$this->title = $title;
	}
}

class ReportDateColumn extends ReportColumn
{
	private $timezone;
	private $format;

	public function __construct($titleKey, $timezone, $format, ChartColumnDefinition $chartColumnDefinition)
	{
		parent::__construct($titleKey, $chartColumnDefinition);
		$this->timezone = $timezone;
		$this->format = $format;
	}

	public function GetData($data)
	{
		return Date::FromDatabase($data)->ToTimezone($this->timezone)->Format($this->format);
	}

	public function GetChartData($row, $key)
	{
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		return Date::FromDatabase($row[$key])->ToTimezone($this->timezone)->GetDate()->Format($format);
	}
}

class ReportTimeColumn extends ReportColumn
{
	public function __construct($titleKey, ChartColumnDefinition $chartColumnDefinition)
	{
		parent::__construct($titleKey, $chartColumnDefinition);
	}

	public function GetData($data)
	{
		return new TimeInterval($data);
	}
}