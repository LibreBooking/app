<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeReservationRepository
{
	public $_Reservations = array();
	
	public function __construct()
	{
		$this->FillRows(); 
	}
	
	public static function GetReservationRows()
	{
		$row1 =  array(ColumnNames::RESERVATION_INSTANCE_ID => 1, 
					ColumnNames::RESERVATION_START => '2008-05-20 09:00:00',
					ColumnNames::RESERVATION_END => '2008-05-20 15:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary1',
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last',
					ColumnNames::REPEAT_START => null,
					ColumnNames::REPEAT_END => null,
					ColumnNames::REFERENCE_NUMBER => 'r1',
					);
					
		$row2 =  array(ColumnNames::RESERVATION_INSTANCE_ID => 1, 
					ColumnNames::RESERVATION_START => '2008-05-20 09:00:00',
					ColumnNames::RESERVATION_END => '2008-05-20 15:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary1',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 2,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last',
					ColumnNames::REPEAT_START => null,
					ColumnNames::REPEAT_END => null,
					ColumnNames::REFERENCE_NUMBER => 'r2',
					);			
					
		$row3 =  array(ColumnNames::RESERVATION_INSTANCE_ID => 2, 
					ColumnNames::RESERVATION_START => '2008-05-22 06:00:00',
					ColumnNames::RESERVATION_END => '2008-05-24 09:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary2',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last',
					ColumnNames::REPEAT_START => null,
					ColumnNames::REPEAT_END => null,
					ColumnNames::REFERENCE_NUMBER => 'r3',
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