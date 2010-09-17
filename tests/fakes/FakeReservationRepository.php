<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class FakeReservationRepository implements IReservationRepository
{
	public $_GetWithinCalled = false;
	public $_LastStartDate;
	public $_LastEndDate;
	public $_LastScheduleId;
	public $_Reservations = array();
	public $_StartDates = array();
	public $_EndDates = array();
	
	public function __construct()
	{
		$this->FillRows(); 
	}
	
	public function GetWithin(Date $startDate, Date $endDate, $scheduleId = ReservationRepository::ALL_SCHEDULES)
	{
		$this->_GetWithinCalled = true;
		$this->_LastStartDate = $startDate;
		$this->_LastEndDate = $endDate;
		$this->_LastScheduleId = $scheduleId;
		
		$this->_StartDates[] = $startDate;
		$this->_EndDates[] = $endDate;
		
		return $this->_Reservations;
	}
	
	public function Add(Reservation $reservation)
	{}
	
	public static function GetReservationRows()
	{
		$row1 =  array(ColumnNames::RESERVATION_ID => 1, 
					ColumnNames::RESERVATION_START => '2008-05-20 09:00:00',
					ColumnNames::RESERVATION_END => '2008-05-20 15:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary1',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last'
					);
					
		$row2 =  array(ColumnNames::RESERVATION_ID => 1, 
					ColumnNames::RESERVATION_START => '2008-05-20 09:00:00',
					ColumnNames::RESERVATION_END => '2008-05-20 15:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary1',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 2,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last'
					);			
					
		$row3 =  array(ColumnNames::RESERVATION_ID => 2, 
					ColumnNames::RESERVATION_START => '2008-05-22 06:00:00',
					ColumnNames::RESERVATION_END => '2008-05-24 09:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary2',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last'
					);
		
		return array(
			$row1, 
			$row2, 
			$row3
			);								
	}
	
	private function FillRows()
	{
		$rows = self::GetReservationRows();
		
		foreach($rows as $row)
		{
			$this->_Reservations[] = ReservationFactory::CreateForSchedule($row);
		}
	}
}

?>