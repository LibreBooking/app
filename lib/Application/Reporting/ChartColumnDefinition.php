<?php
/**
Copyright 2012-2020 Nick Korbel

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
class ChartType
{
	const Total = 'total';
	const TotalTime = 'totalTime';
	const Date = 'date';
}

class ChartColumnType
{
	const Label = 'label';
	const Total = 'total';
	const Date = 'date';
}

class ChartGroup
{
	const Accessory = 'a';
	const Resource = 'r';
	const User = 'u';
}

class ChartColumnDefinition
{
	/**
	 * @var ChartColumnType|string
	 */
	private $chartColumnType;
	/**
	 * @var null|string
	 */
	private $dataColumnName;
	/**
	 * @var ChartGroup|null|string
	 */
	private $chartGroup;

	/**
	 * @param string|ChartColumnType $chartColumnType
	 * @param string|null $dataColumnName
	 * @param string|null|ChartGroup $chartGroup
	 */
	private function __construct($chartColumnType, $dataColumnName = null, $chartGroup = null)
	{
		$this->chartColumnType = $chartColumnType;
		$this->dataColumnName = $dataColumnName;
		$this->chartGroup = $chartGroup;
	}

	/**
	 * @static
	 * @param string $dataColumnName
	 * @param string|ChartGroup $chartGroup
	 * @return ChartColumnDefinition
	 */
	public static function Label($dataColumnName, $chartGroup = null)
	{
		return new ChartColumnDefinition(ChartColumnType::Label, $dataColumnName, $chartGroup);
	}

	/**
	 * @static
	 * @return ChartColumnDefinition
	 */
	public static function Null()
	{
		return new ChartColumnDefinition(null);
	}

	/**
	 * @static
	 * @return ChartColumnDefinition
	 */
	public static function Date()
	{
		return new ChartColumnDefinition(ChartColumnType::Date);
	}

	/**
	 * @static
	 * @return ChartColumnDefinition
	 */
	public static function Total()
	{
		return new ChartColumnDefinition(ChartColumnType::Total);
	}

	/**
	 * @return ChartColumnType|string
	 */
	public function ChartColumnType()
	{
		return $this->chartColumnType;
	}

	/**
	 * @param $row array
	 * @param $columnKey string
	 */
	public function GetChartData($row, $columnKey)
	{
		if (empty($this->dataColumnName))
		{
			return $row[$columnKey];
		}
		return $row[$this->dataColumnName];
	}

	/**
	 * @return ChartGroup|null|string
	 */
	public function GetChartGroup()
	{
		return $this->chartGroup;
	}
}