<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationsTests extends TestBase
{
	private $reservations;
	
	public function setup()
	{
		parent::setup();
		
		$this->reservations = new Reservations();
	}
	
	public function teardown()
	{
		parent::teardown();
		
		$this->reservations = null;
	}
	
	public function testCanGetReservationsWithinDateRange()
	{
		$startDate = Date::Create(2008, 05, 20);
		$endDate = Date::Create(2008, 05, 25);
		$scheduleId = 1;
		
		$rows = $this->GetReservationRows();
		$this->db->SetRow(0, $rows);
		
		$expected = array();
		foreach ($rows as $item)
		{
			$expected[] = ReservationFactory::CreateForSchedule($item);
		}

		$loaded = $this->reservations->GetWithin($startDate, $endDate, $scheduleId);		
		
		$this->assertEquals(new GetReservationsCommand($startDate, $endDate, $scheduleId), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals(count($rows), count($loaded));
		$this->assertEquals($expected, $loaded);
	}
	
	public function testCanCreateScheduleReservation()
	{
		$rows = $this->GetReservationRows();
		
		$r = $rows[0];
		$expected = new ScheduleReservation(
							$r[ColumnNames::RESERVATION_ID],
							$r[ColumnNames::START_DATE],
							$r[ColumnNames::END_DATE],
							$r[ColumnNames::START_TIME],
							$r[ColumnNames::END_TIME],
							$r[ColumnNames::RESERVATION_TYPE],
							$r[ColumnNames::SUMMARY],
							$r[ColumnNames::PARENT_ID],
							$r[ColumnNames::RESOURCE_ID],
							$r[ColumnNames::USER_ID],
							$r[ColumnNames::FIRST_NAME],
							$r[ColumnNames::LAST_NAME]
						);
		
		
		$actual = ReservationFactory::CreateForSchedule($r);
		
		$this->assertEquals($expected, $actual);
	}
	
	private function GetReservationRows()
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
}

?>
