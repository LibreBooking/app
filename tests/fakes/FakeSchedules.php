<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class FakeScheduleRepository implements IScheduleRepository
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
			array(
				ColumnNames::SCHEDULE_ID => $this->_DefaultScheduleId,
				ColumnNames::SCHEDULE_NAME => 'schedule 1',
				ColumnNames::SCHEDULE_DEFAULT => 1,
				ColumnNames::SCHEDULE_WEEKDAY_START => $this->_DefaultDayStart,
				ColumnNames::SCHEDULE_DAYS_VISIBLE => $this->_DefaultDaysVisible
			),
			array(
				ColumnNames::SCHEDULE_ID => 2,
				ColumnNames::SCHEDULE_NAME => 'schedule 2',
				ColumnNames::SCHEDULE_DEFAULT => 0,
				ColumnNames::SCHEDULE_WEEKDAY_START => 0,
				ColumnNames::SCHEDULE_DAYS_VISIBLE => 5
			)
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
							$item[ColumnNames::SCHEDULE_DAYS_VISIBLE]
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
}
?>