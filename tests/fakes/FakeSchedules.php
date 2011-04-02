<?php
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
	
	public static function GetRow($id, $name, $isDefault, $weekdayStart, $daysVisible, $timezone)
	{
		return array(
				ColumnNames::SCHEDULE_ID => $id,
				ColumnNames::SCHEDULE_NAME => $name,
				ColumnNames::SCHEDULE_DEFAULT => $isDefault,
				ColumnNames::SCHEDULE_WEEKDAY_START => $weekdayStart,
				ColumnNames::SCHEDULE_DAYS_VISIBLE => $daysVisible,
				ColumnNames::TIMEZONE_NAME => $timezone
			);
	}
}
?>