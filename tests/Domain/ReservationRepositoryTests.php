<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
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
							$r[ColumnNames::RESERVATION_INSTANCE_ID],
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
		$seriesId = 100;
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
		
		$this->db->_ExpectedInsertIds[0] = $seriesId;
		$this->db->_ExpectedInsertIds[1] = $reservationId;
		
		$reservation = new ReservationSeries();
		$reservation->Update($userId, $resourceId, $scheduleId, $title, $description);
		$reservation->UpdateDuration($duration);
		
		$repeatOptions = new NoRepetion();
		$repeatType = $repeatOptions->RepeatType();
		$repeatOptionsString = $repeatOptions->ConfigurationString();
		$referenceNumber = $reservation->GetInstance($duration->GetBegin())->ReferenceNumber();
		
		$this->repository->Add($reservation);
		
		$insertReservationSeries = new AddReservationSeriesCommand(
				$dateCreatedUtc,
				$title, 
				$description, 
				$repeatType, 
				$repeatOptionsString, 
				$scheduleId, 
				ReservationTypes::Reservation,
				ReservationStatus::Created);
		
		$insertReservation = new AddReservationCommand(
				$startUtc, 
				$endUtc, 
				$referenceNumber, 
				$seriesId);
		
		$insertReservationResource = new AddReservationResourceCommand(
				$seriesId, 
				$resourceId, 
				ResourceLevel::Primary);
		
		$insertReservationUser = new AddReservationUserCommand(
				$seriesId, 
				$userId, 
				$levelId);
		
		$this->assertEquals($insertReservationSeries, $this->db->_Commands[0]);
		$this->assertEquals($insertReservationResource, $this->db->_Commands[1]);
		$this->assertEquals($insertReservationUser, $this->db->_Commands[2]);
		$this->assertEquals($insertReservation, $this->db->_Commands[3]);

		$this->assertEquals(4, count($this->db->_Commands));
	}
	
	public function testRepeatedDatesAreSaved()
	{
		$reservationSeriesId = 109;
		$reservationId = 918;
		$repeatId1 = 919;
		$repeatId2 = 920;
		$repeatId3 = 921;
		
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
		
		$this->db->_ExpectedInsertIds[0] = $reservationSeriesId;
		$this->db->_ExpectedInsertIds[1] = $reservationId;
		$this->db->_ExpectedInsertIds[2] = $repeatId1;
		$this->db->_ExpectedInsertIds[3] = $repeatId3;
		
		$this->repository->Add($reservation);
		
		$insertRepeatDate1 = new AddReservationCommand(
				$startUtc1, 
				$endUtc1, 				
				$reservation->GetInstance($startUtc1)->ReferenceNumber(), 
				$reservationSeriesId);
				
		$insertRepeatDate2 = new AddReservationCommand(
				$startUtc2, 
				$endUtc2, 
				$reservation->GetInstance($startUtc2)->ReferenceNumber(), 
				$reservationSeriesId);
				
		$insertRepeatDate3 = new AddReservationCommand(
				$startUtc3, 
				$endUtc3, 
				$reservation->GetInstance($startUtc3)->ReferenceNumber(), 
				$reservationSeriesId);
		
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
		
		$this->db->_ExpectedInsertId = $seriesId;
				
		$this->repository->Add($reservation);
		
		$insertResource1 = new AddReservationResourceCommand($seriesId, $id1, ResourceLevel::Additional);
		$insertResource2 = new AddReservationResourceCommand($seriesId, $id2, ResourceLevel::Additional);
		
		$this->assertTrue(in_array($insertResource1, $this->db->_Commands));
		$this->assertTrue(in_array($insertResource2, $this->db->_Commands));
	}
	
	public function testLoadByIdFullyHydratesReservationSeriesObject()
	{
		$this->markTestIncomplete('need to refactor this a lot to get into series structure');
		$seriesId = 10;
		$reservationId = 1;
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
		$expected->IsPartOfSeries($seriesId);
		$expected->SetReferenceNumber($referenceNumber);
		$expected->SetReservationId($reservationId);
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
			$scheduleId,
			$seriesId
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
		$this->markTestIncomplete('This test has not been implemented yet.');
		
		$reservationId = 1;
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
		$expected->SetReservationId($reservationId);;
		$expected->Update($userId, $resourceId, $scheduleId, $title, $description);
		$expected->AddResource($resourceId1);
		$expected->AddResource($resourceId2);
		$expected->UpdateDuration($duration);
		$expected->Repeats($repeatOptions);	
		
		$updateReservation = new UpdateReservationCommand(
										$reservation->StartDate(), 
										$reservation->EndDate(), 
										Date::Now(), 
										$reservation->Title(), 
										$reservation->Description(),
										$reservation->RepeatOptions()->RepeatType(),
										$reservation->RepeatOptions()->ConfigurationString(),
										$reservation->ReferenceNumber(),
										$reservation->ScheduleId(),
										ReservationTypes::Reservation,
										ReservationStatus::Created);
		
		$addResourceCommand = new AddReservationResourceCommand($reservationId, $resourceId, ResourceLevel::Additional);										
		$deleteResourceCommand = new DeleteReservationResourceCommand($reservationId, $resourceId);										
		$deleteResourceCommand = new DeleteReservationResourceCommand($reservationId, $resourceId);										
		
		// TODO: need to modify repeated date or reservation itself
		$this->markTestIncomplete('no idea how to do this');
		$this->repository->Update($reservation);
		
	}
	
	public function testAlteringReservationInstanceCreatesNewSeries()
	{
		
	}
	
	public function testAlteringSeriesLeavesSeriesIntact()
	{
		
	}
	
	public function testAlteringFutureInstancesCreatesNewSeriesAnMovesExistingReservationsThere()
	{}
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
		$scheduleId,
		$seriesId
		)
	{
		$this->row =  array(
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId,
			ColumnNames::RESERVATION_START => $startDate,
			ColumnNames::RESERVATION_END => $endDate,
			ColumnNames::RESERVATION_TITLE => $title,
			ColumnNames::RESERVATION_DESCRIPTION => $description,
			ColumnNames::RESERVATION_TYPE => ReservationTypes::Reservation,
			ColumnNames::REPEAT_TYPE => $repeatType,
			ColumnNames::REPEAT_OPTIONS => $repeatOptions,
			ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::SCHEDULE_ID => $scheduleId,
			ColumnNames::SERIES_ID => $seriesId
		);
	}
}

class ReservationResourceRow
{
	private $seriesId;
	private $rows = array();
	
	public function Rows()
	{
		return $this->rows;
	}
	
	public function __construct($seriesId)
	{
		$this->seriesId = $seriesId;
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
		$this->rows[] = array(ColumnNames::SERIES_ID => $this->seriesId, ColumnNames::RESOURCE_ID => $resourceId, ColumnNames::RESOURCE_LEVEL_ID => $levelId);
	}
}

class ReservationUserRow
{
	private $seriesId;
	private $rows = array();
	
	public function Rows()
	{
		return $this->rows;
	}
	
	public function __construct($seriesId)
	{
		$this->seriesId = $seriesId;
	}
	
	public function WithOwner($userId)
	{
		$this->AddRow($userId, ReservationUserLevel::OWNER);
		return $this;
	}
	
	private function AddRow($userId, $levelId)
	{
		$this->rows[] = array(ColumnNames::SERIES_ID => $this->seriesId, ColumnNames::USER_ID => $userId, ColumnNames::RESERVATION_USER_LEVEL => $levelId);
	}
}

class TestReservation extends ReservationSeries
{
	public function __construct()
	{
		parent::__construct();
	}
}

?>
