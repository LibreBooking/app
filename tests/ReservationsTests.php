<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

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
		$this->markTestIncomplete('need to load reservation data with all reservations');
		
		$startDate = Date::Create(2008, 05, 20);
		$endDate = Date::Create(2008, 05, 25);
		$scheduleId = 1;
		
		//$fakeReservaions = new FakeReservations();
		$rows = $this->GetReservationRows();//$fakeReservaions->GetRows();
		$this->db->SetRow(0, $rows);
		
		$expected = array();
		foreach ($rows as $item)
		{
			// Maybe this should use something like:
			// ReservationFactory::CreateForSchedule($item)
			$expected[] = new ScheduleReservation(
							$item[ColumnNames::RESERVATION_ID],
							$item[ColumnNames::START_DATE],
							$item[ColumnNames::END_DATE],
							$item[ColumnNames::START_TIME],
							$item[ColumnNames::END_TIME],
							$item[ColumnNames::RESERVATION_TYPE],
							$item[ColumnNames::SUMMARY],
							$item[ColumnNames::PARENT_ID],
							$item[ColumnNames::RESOURCE_ID],
							$item[ColumnNames::USER_ID],
							$item[ColumnNames::FIRST_NAME],
							$item[ColumnNames::LAST_NAME]
						);
		}
		
		

		$loaded = $this->reservations->GetWithin($startDate, $endDate, $scheduleId);
		
		
		$this->assertEquals(new GetReservationsWithinDateRange($startDate, $endDate, $scheduleId), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals(2, count($loaded));
		$this->assertEquals($expected, $loaded);
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