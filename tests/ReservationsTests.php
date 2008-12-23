<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationsTests extends TestBase
{
	private $reservations;
	
	public function setup()
	{
		parent::setup();
		
		$this->reservations = new ReservationRepository();
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
		
		$rows = FakeReservationRepository::GetReservationRows();
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
		$rows = FakeReservationRepository::GetReservationRows();
		
		$r = $rows[0];
		$expected = new ScheduleReservation(
							$r[ColumnNames::RESERVATION_ID],
							$r[ColumnNames::START_DATE],
							$r[ColumnNames::END_DATE],
							$r[ColumnNames::RESERVATION_TYPE],
							$r[ColumnNames::SUMMARY],
							$r[ColumnNames::PARENT_ID],
							$r[ColumnNames::RESOURCE_ID],
							$r[ColumnNames::USER_ID],
							$r[ColumnNames::FIRST_NAME],
							$r[ColumnNames::LAST_NAME]
						);
		
		$actual = ReservationFactory::CreateForSchedule($r);
		
		$startTime = Time::Parse($r[ColumnNames::START_DATE], 'UTC');
		$endTime = Time::Parse($r[ColumnNames::END_DATE], 'UTC');
		
		$startDate = Date::Parse($r[ColumnNames::START_DATE], 'UTC');
		$endDate = Date::Parse($r[ColumnNames::END_DATE], 'UTC');
		
		$this->assertEquals($expected, $actual);		
		
		$this->assertTrue($startDate->Equals($actual->GetStartDate()));
		$this->assertTrue($endDate->Equals($actual->GetEndDate()));
		
		$this->assertTrue($startTime->Equals($actual->GetStartTime()));
		$this->assertTrue($endTime->Equals($actual->GetEndTime()));
	}
}

?>
