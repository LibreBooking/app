<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class FakeReservations implements IReservationRepository
{
	public $_GetWithinCalled = false;
	public $_LastStartDate;
	public $_LastEndDate;
	public $_LastScheduleId;
	public $_Reservations = array();
	
	public function __construct()
	{
		$this->FillRows(); 
	}
	
	public function GetWithin(Date $startDate, Date $endDate, $scheduleId)
	{
		$this->_GetWithinCalled = true;
		$this->_LastStartDate = $startDate;
		$this->_LastEndDate = $endDate;
		$this->_LastScheduleId = $scheduleId;
		
		
		return $this->_Reservations;
	}
	
	public function GetReservationRows()
	{
		$row1 =  array(ColumnNames::RESERVATION_ID => 1, 
					ColumnNames::START_DATE => '2008-05-20 00:00:00',
					ColumnNames::END_DATE => '2008-05-20 00:00:00',
					ColumnNames::START_TIME => '09:00',
					ColumnNames::END_TIME => '15:30',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::SUMMARY => 'summary1',
					ColumnNames::PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last'
					);
					
		$row2 =  array(ColumnNames::RESERVATION_ID => 1, 
					ColumnNames::START_DATE => '2008-05-20 00:00:00',
					ColumnNames::END_DATE => '2008-05-20 00:00:00',
					ColumnNames::START_TIME => '09:00',
					ColumnNames::END_TIME => '15:30',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::SUMMARY => 'summary1',
					ColumnNames::PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 2,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last'
					);			
					
		$row3 =  array(ColumnNames::RESERVATION_ID => 2, 
					ColumnNames::START_DATE => '2008-05-22 00:00:00',
					ColumnNames::END_DATE => '2008-05-24 00:00:00',
					ColumnNames::START_TIME => '06:00',
					ColumnNames::END_TIME => '09:30',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::SUMMARY => 'summary2',
					ColumnNames::PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last'
					);
		
		return array($row1, $row2, $row3);								
	}
	
	private function FillRows()
	{
		$rows = $this->GetReservationRows();
		
		foreach($rows as $row)
		{
			$this->_Reservations[] = ReservationFactory::CreateForSchedule($row);
		}
	}
}

?>