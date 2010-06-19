<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationsTests extends TestBase
{
	/**
	 * @var ReservationRepository
	 */
	private $repository;
	
	public function setup()
	{
		parent::setup();
		
		$this->repository = new ReservationRepository();
	}
	
	public function teardown()
	{
		parent::teardown();
		
		$this->repository = null;
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

		$loaded = $this->repository->GetWithin($startDate, $endDate, $scheduleId);		
		
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
							Date::Parse($r[ColumnNames::RESERVATION_START], 'UTC'),
							Date::Parse($r[ColumnNames::RESERVATION_END], 'UTC'),
							$r[ColumnNames::RESERVATION_TYPE],
							$r[ColumnNames::RESERVATION_DESCRIPTION],
							$r[ColumnNames::RESERVATION_PARENT_ID],
							$r[ColumnNames::RESOURCE_ID],
							$r[ColumnNames::USER_ID],
							$r[ColumnNames::FIRST_NAME],
							$r[ColumnNames::LAST_NAME]
						);
		
		$actual = ReservationFactory::CreateForSchedule($r);
		
		$startTime = Time::Parse($r[ColumnNames::RESERVATION_START], 'UTC');
		$endTime = Time::Parse($r[ColumnNames::RESERVATION_END], 'UTC');
		
		$startDate = Date::Parse($r[ColumnNames::RESERVATION_START], 'UTC');
		$endDate = Date::Parse($r[ColumnNames::RESERVATION_END], 'UTC');
		
		$this->assertEquals($expected, $actual);		
		
		$this->assertTrue($startDate->Equals($actual->GetStartDate()));
		$this->assertTrue($endDate->Equals($actual->GetEndDate()));
		
		$this->assertTrue($startTime->Equals($actual->GetStartTime()));
		$this->assertTrue($endTime->Equals($actual->GetEndTime()));
	}

	public function testAddReservationWithOneUserAndOneResource()
	{
		$reservationId = 428;
		$userId = 232;
		$resourceId = 10978;
		$title = 'title';
		$description = 'description';
		$startCst = '2010-02-15 16:30';
		$endCst = '2010-02-16 17:00';
		$duration = DateRange::Create($startCst, $endCst, 'CST');

		$startUtc = Date::Parse($startCst, 'CST')->ToUtc();
		$endUtc = Date::Parse($endCst, 'CST')->ToUtc();
		
		$dateCreatedUtc = Date::Parse('2010-01-01 12:14:16', 'UTC');
		Date::_SetNow($dateCreatedUtc);
		
		$this->db->_ExpectedInsertId = $reservationId;
		
		$reservation = new Reservation();
		$reservation->Update($userId, $resourceId, $title, $description);
		$reservation->UpdateDuration($duration);
		
		$this->repository->Add($reservation);
		
		$insertReservation = new InsertReservationCommand($startUtc, $endUtc, $dateCreatedUtc, $title, $description);
		$insertReservationResource = new InsertReservationResourceCommand($reservationId, $resourceId);
		$insertReservationUser = new InsertReservationUserCommand($reservationId, $userId, $levelId);
		
		$this->assertEquals($insertReservationCommand, $this->db->_Commands[0]);
		$this->assertEquals($insertReservationResource, $this->db->_Commands[1]);
		$this->assertEquals($insertReservationUser, $this->db->_Commands[2]);
		
		$this->assertEquals(3, count($this->db->_Commands));
	}
}

?>
