<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class FakeSchedules implements ISchedules
{	
	public $_GetAllCalled = false;
	public $_AllRows = array();
	
	public function __construct()
	{
		$this->_AllRows = $this->_GetAllRows();
	}
	
	public function GetRows()
	{
		return array(
			array(
				ColumnNames::SCHEDULE_ID => 1,
				ColumnNames::SCHEDULE_NAME => 'schedule 1',
				ColumnNames::SCHEDULE_DEFAULT => 1,
				ColumnNames::SCHEDULE_START => '06:00',
				ColumnNames::SCHEDULE_END => '17:00',
				ColumnNames::SCHEDULE_WEEKDAY_START => 0,
				ColumnNames::SCHEDULE_ADMIN_ID => 1,
				ColumnNames::SCHEDULE_DAYS_VISIBLE => 7
			),
			array(
				ColumnNames::SCHEDULE_ID => 2,
				ColumnNames::SCHEDULE_NAME => 'schedule 2',
				ColumnNames::SCHEDULE_DEFAULT => 0,
				ColumnNames::SCHEDULE_START => '08:00',
				ColumnNames::SCHEDULE_END => '12:00',
				ColumnNames::SCHEDULE_WEEKDAY_START => 0,
				ColumnNames::SCHEDULE_ADMIN_ID => 2,
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
							$item[ColumnNames::SCHEDULE_START],
							$item[ColumnNames::SCHEDULE_END],
							$item[ColumnNames::SCHEDULE_WEEKDAY_START],
							$item[ColumnNames::SCHEDULE_ADMIN_ID],
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
}
?>