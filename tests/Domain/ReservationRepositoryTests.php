<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');

class ReservationRepositoryTests extends TestBase
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
							null, //$r[ColumnNames::RESERVATION_PARENT_ID],
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
		$scheduleId = 123;
		$title = 'title';
		$description = 'description';
		$startCst = '2010-02-15 16:30';
		$endCst = '2010-02-16 17:00';
		$duration = DateRange::Create($startCst, $endCst, 'CST');
		$levelId = ReservationUserLevel::OWNER;
		
		$startUtc = Date::Parse($startCst, 'CST')->ToUtc();
		$endUtc = Date::Parse($endCst, 'CST')->ToUtc();
		
		$dateCreatedUtc = Date::Parse('2010-01-01 12:14:16', 'UTC');
		Date::_SetNow($dateCreatedUtc);
		
		$this->db->_ExpectedInsertId = $reservationId;
		
		$reservation = new Reservation();
		$reservation->Update($userId, $resourceId, $scheduleId, $title, $description);
		$reservation->UpdateDuration($duration);
		
		$repeatOptions = new NoRepetion();
		$repeatType = $repeatOptions->RepeatType();
		$repeatOptionsString = $repeatOptions->ConfigurationString();
		$referenceNumber = $reservation->ReferenceNumber();
		
		$this->repository->Add($reservation);
		
		$insertReservation = new AddReservationCommand(
				$startUtc, 
				$endUtc, 
				$dateCreatedUtc, 
				$title, 
				$description, 
				$repeatType, 
				$repeatOptionsString, 
				$referenceNumber, 
				$scheduleId, 
				ReservationTypes::Reservation,
				ReservationStatus::Created);
		
		$insertReservationResource = new AddReservationResourceCommand(
				$reservationId, 
				$resourceId, 
				ResourceLevel::Primary);
		
		$insertReservationUser = new AddReservationUserCommand($reservationId, $userId, $levelId);
		
		$this->assertEquals($insertReservation, $this->db->_Commands[0]);
		$this->assertEquals($insertReservationResource, $this->db->_Commands[1]);
		$this->assertEquals($insertReservationUser, $this->db->_Commands[2]);
		
		$this->assertEquals(3, count($this->db->_Commands));
	}
	
	public function testRepeatedDatesAreSaved()
	{
		$reservationId = 918;
		$timezone = 'UTC';
		
		$startUtc1 = Date::Parse('2010-02-03', $timezone);
		$startUtc2 = Date::Parse('2010-02-04', $timezone);
		$startUtc3 = Date::Parse('2010-02-05', $timezone);
		$endUtc1 = Date::Parse('2010-02-06', $timezone);
		$endUtc2 = Date::Parse('2010-02-07', $timezone);
		$endUtc3 = Date::Parse('2010-02-08', $timezone);
		
		$dates[] = new DateRange($startUtc1, $endUtc1, $timezone);
		$dates[] = new DateRange($startUtc2, $endUtc2, $timezone);
		$dates[] = new DateRange($startUtc3, $endUtc3, $timezone);
		
		$repeats = $this->getMock('IRepeatOptions');
		$repeats->expects($this->once())
			->method('GetDates')
			->will($this->returnValue($dates));

		$reservation = new TestReservation();
		$reservation->Repeats($repeats);
		
		$this->db->_ExpectedInsertId = $reservationId;
		
		$this->repository->Add($reservation);
		
		$insertRepeatDate1 = new AddReservationRepeatDateCommand($reservationId, $startUtc1->ToUtc(), $endUtc1->ToUtc());
		$insertRepeatDate2 = new AddReservationRepeatDateCommand($reservationId, $startUtc2->ToUtc(), $endUtc2->ToUtc());
		$insertRepeatDate3 = new AddReservationRepeatDateCommand($reservationId, $startUtc3->ToUtc(), $endUtc3->ToUtc());
		
		$this->assertTrue(in_array($insertRepeatDate1, $this->db->_Commands));
		$this->assertTrue(in_array($insertRepeatDate2, $this->db->_Commands));
		$this->assertTrue(in_array($insertRepeatDate3, $this->db->_Commands));
	}
	
	public function testCanAddAdditionalResources()
	{
		$reservationId = 999;
		$id1 = 1;
		$id2 = 2;
		
		$reservation = new TestReservation();
		$reservation->AddResource($id1);
		$reservation->AddResource($id2);
		
		$this->db->_ExpectedInsertId = $reservationId;
				
		$this->repository->Add($reservation);
		
		$insertResource1 = new AddReservationResourceCommand($reservationId, $id1, ResourceLevel::Additional);
		$insertResource2 = new AddReservationResourceCommand($reservationId, $id2, ResourceLevel::Additional);
		
		$this->assertTrue(in_array($insertResource1, $this->db->_Commands));
		$this->assertTrue(in_array($insertResource2, $this->db->_Commands));
	}
	
	public function testLoadByIdFullyHydratesReservationObject()
	{
		$referenceNumber = 'refnum';
		$userId = 10;
		$resourceId = 100;
		$scheduleId = 1000;
		$title = 'title';
		$description = 'description';
		$resourceId1 = 99;
		$resourceId2 = 999;
		$begin = '2010-01-05 12:30:00';
		$end = '2010-01-05 18:30:00';
		$duration = DateRange::Create($begin, $end, 'UTC');
		$interval = 3;
		$repeatType = RepeatType::Daily;
		$terminiationDateString = '2010-01-20 12:30:00'; 
		$terminationDate = Date::FromDatabase($terminiationDateString);
		$repeatOptions = new DailyRepeat($interval, $terminationDate, $duration);
		
		$expected = new ExistingReservation();
		$expected->SetReferenceNumber($referenceNumber);
		$expected->Update($userId, $resourceId, $scheduleId, $title, $description);
		$expected->AddResource($resourceId1);
		$expected->AddResource($resourceId2);
		$expected->UpdateDuration($duration);
		$expected->Repeats($repeatOptions);
		
		$reservationRow = new ReservationRow(
			$reservationId,
			$begin,
			$end,
			$title,
			$description,
			$repeatType,
			$repeatOptions->ConfigurationString(),
			$referenceNumber,
			$scheduleId
			);
			
		$reservationResourceRow = new ReservationResourceRow($reservationId);
		$reservationResourceRow
			->WithPrimary($resourceId)
			->WithAdditional($resourceId1)
			->WithAdditional($resourceId2);
			
		$reservationUserRow = new ReservationUserRow($reservationId);
		$reservationUserRow
			->WithOwner($userId);
		
		$this->db->SetRow(0, $reservationRow->Rows());
		$this->db->SetRow(1, $reservationResourceRow->Rows());
		$this->db->SetRow(2, $reservationUserRow->Rows());
		
		$reservationId = 1;
		$actualReservation = $this->repository->LoadById($reservationId);
		
		$this->assertEquals($expected, $actualReservation);
		
		$getReservation = new GetReservationByIdCommand($reservationId);
		$getResources = new GetReservationResourcesCommand($reservationId);
		$getParticipants = new GetReservationParticipantsCommand($reservationId);
		
		$this->assertTrue(in_array($getReservation, $this->db->_Commands));
		$this->assertTrue(in_array($getResources, $this->db->_Commands));
		$this->assertTrue(in_array($getParticipants, $this->db->_Commands));
	}
	
	public function testUpdateSavesChangedReservationData()
	{
		$reservation = new Reservation();
		
		$this->repository->Update($reservation);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
}


class ReservationRow
{
	private $row = array();
	
	public function Rows()
	{
		return array($this->row);
	}
	
	public function __construct(
		$reservationId, 
		$startDate, 
		$endDate,
		$title,
		$description,
		$repeatType,
		$repeatOptions,
		$referenceNumber,
		$scheduleId)
	{
		$this->row =  array(
			ColumnNames::RESERVATION_ID => $reservationId,
			ColumnNames::RESERVATION_START => $startDate,
			ColumnNames::RESERVATION_END => $endDate,
			'date_created' => '2010-12-20 20:15:20',
			'last_modified' => '2010-12-20 14:15:20',
			'title' => $title,
			'description' => $description,
			'type_id' => ReservationTypes::Reservation,
			'status_id' => ReservationStatus::Created,
			'repeat_type' => $repeatType,
			'repeat_options' => $repeatOptions,
			'reference_number' => $referenceNumber,
			'schedule_id' => $scheduleId
		);
	}
}

class ReservationResourceRow
{
	private $reservationId;
	private $rows = array();
	
	public function Rows()
	{
		return $this->rows;
	}
	
	public function __construct($reservationId)
	{
		$this->reservationId = $reservationId;
	}
	
	public function WithPrimary($resourceId)
	{
		$this->AddRow($resourceId, ResourceLevel::Primary);
		return $this;
	}
	
	public function WithAdditional($resourceId)
	{
		$this->AddRow($resourceId, ResourceLevel::Additional);
		return $this;
	}
	
	private function AddRow($resourceId, $levelId)
	{
		$this->rows[] = array(ColumnNames::RESERVATION_ID => $this->reservationId, ColumnNames::RESOURCE_ID => $resourceId, ColumnNames::RESOURCE_LEVEL_ID => $levelId);
	}
}

class ReservationUserRow
{
	private $reservationId;
	private $rows = array();
	
	public function Rows()
	{
		return $this->rows;
	}
	
	public function __construct($reservationId)
	{
		$this->reservationId = $reservationId;
	}
	
	public function WithOwner($userId)
	{
		$this->AddRow($userId, ReservationUserLevel::OWNER);
		return $this;
	}
	
	private function AddRow($userId, $levelId)
	{
		$this->rows[] = array(ColumnNames::RESERVATION_ID => $this->reservationId, ColumnNames::USER_ID => $userId, ColumnNames::RESERVATION_USER_LEVEL => $levelId);
	}
}

class TestReservation extends Reservation
{
	public function __construct()
	{
		$this->_startDate = Date::Now();
		$this->_endDate = Date::Now();
		parent::__construct();
	}
}

?>
