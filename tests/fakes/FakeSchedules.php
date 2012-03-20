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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeScheduleRepository
{	
	public $_GetAllCalled = false;
	public $_AllRows = array();
	
	public $_DefaultScheduleId = 1;
	public $_DefaultDaysVisible = 7;
	public $_DefaultStartTime = '06:00';
	public $_DefaultEndTime = '17:00';
	public $_DefaultDayStart = 0;
	
	public function __construct()
	{
		$this->_AllRows = $this->_GetAllRows();
	}
	
	/**
	 * @var Schedule
	 */
	public static $Schedule1;
	
	public static function Initialize()
	{
		self::$Schedule1 = new Schedule(1, "schedule 1", true, '09:00', '20:00', 0, 1, 5);
	}
	
	public function GetRows()
	{
		return array(
			self::GetRow($this->_DefaultScheduleId, 'schedule 1', 1, $this->_DefaultDayStart, $this->_DefaultDaysVisible, 'America/Chicago'),
			self::GetRow(2, 'schedule 1', 0, 0, 5, 'America/Chicago'),
		);
	}
	
	private function _GetAllRows()
	{
		$rows = $this->GetRows();
		$expected = array();
		
		foreach ($rows as $item)
		{
			$expected[] = new Schedule(
							$item[ColumnNames::SCHEDULE_ID],
							$item[ColumnNames::SCHEDULE_NAME],
							$item[ColumnNames::SCHEDULE_DEFAULT],
							$item[ColumnNames::SCHEDULE_WEEKDAY_START],
							$item[ColumnNames::SCHEDULE_DAYS_VISIBLE],
							$item[ColumnNames::TIMEZONE_NAME]
						);
		}
		
		return $expected;
	}
	
	public function GetAll()
	{
		$this->_GetAllCalled = true;
		return $this->_AllRows;
	}
	
	public function GetLayout($scheduleId, ILayoutFactory $layoutFactory)
	{
		throw new Exception("not implemented");
	}
	
	public function LoadById($scheduleId)
	{
		throw new Exception('mock this');
	}
	
	public function Update(Schedule $schedule)
	{
		throw new Exception('mock this');
	}
	
	public function AddScheduleLayout($scheduleId, IScheduleLayout $layout)
	{
		throw new Exception('mock this');
	}
	
	public static function GetRow($id = 1, $name = 'name', $isDefault = false, $weekdayStart = 0, $daysVisible = 7, $timezone = 'America/Chicago', $layoutId = null)
	{
		return array(
				ColumnNames::SCHEDULE_ID => $id,
				ColumnNames::SCHEDULE_NAME => $name,
				ColumnNames::SCHEDULE_DEFAULT => $isDefault,
				ColumnNames::SCHEDULE_WEEKDAY_START => $weekdayStart,
				ColumnNames::SCHEDULE_DAYS_VISIBLE => $daysVisible,
				ColumnNames::TIMEZONE_NAME => $timezone,
				ColumnNames::LAYOUT_ID => $layoutId
			);
	}
}
?>