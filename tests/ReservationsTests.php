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
		
		$rows = FakeReservations::GetReservationRows();
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
		$rows = FakeReservations::GetReservationRows();
		
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
	
	
}

?>
