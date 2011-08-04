<?php
class ReservationViewRepositoryTests extends TestBase
{
	/**
	 * @var ReservationViewRepository
	 */
	private $repository;
	
	
	public function setup()
	{
		parent::setup();
		
		$this->repository = new ReservationViewRepository();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testBuildsViewObjectFromDatabase()
	{
		$referenceNumber = "12345";
		$reservationId = 187;
		$resourceId = 12;
		$scheduleId = 73;
		$startDate = new Date('2010-01-01 05:00', 'UTC');
		$endDate = new Date('2010-01-01 12:00', 'UTC');
		$ownerId = 92;
		$title = 'ti';
		$description = 'de';
		$repeatType = RepeatType::Yearly;
		$repeatOptions = 'interval=5';
		$seriesId = 1000;
		$ownerFirst = 'f';
		$ownerLast = 'l';
		
		$resourceId1 = 88;
		$resourceName1 = 'r1';
		
		$resourceId2 = 99;
		$resourceName2 = 'r2';
		
		$userId1 = 87;
		$fname1 = 'f1';
		$lname1 = 'l1';
		$email1 = 'e1';

		$userId2 = 97;
		$fname2 = 'f2';
		$lname2 = 'l2';
		$email2 = 'e2';

		$userId3 = 98;
		$fname3 = 'f3';
		$lname3 = 'l3';
		$email3 = 'e3';
		
		$ownerLevel = ReservationUserLevel::OWNER;
		$participantLevel = ReservationUserLevel::PARTICIPANT;
		$inviteeLevel = ReservationUserLevel::INVITEE;

		$getReservationForEditingCommand = new GetReservationForEditingCommand($referenceNumber);
		$getReservationResources = new GetReservationResourcesCommand($seriesId);
		$getParticpants = new GetReservationParticipantsCommand($reservationId);

		$reservationRow = array(
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId,
			ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::RESOURCE_ID => $resourceId,
			ColumnNames::SCHEDULE_ID => $scheduleId,
			ColumnNames::RESERVATION_START => $startDate->ToDatabase(),
			ColumnNames::RESERVATION_END => $endDate->ToDatabase(),
			ColumnNames::USER_ID => $ownerId,
			ColumnNames::RESERVATION_TITLE => $title,
			ColumnNames::RESERVATION_DESCRIPTION => $description,
			ColumnNames::REPEAT_TYPE => $repeatType,
			ColumnNames::REPEAT_OPTIONS => $repeatOptions,
			ColumnNames::SERIES_ID => $seriesId,
			ColumnNames::FIRST_NAME => $ownerFirst,
			ColumnNames::LAST_NAME => $ownerLast,
		);
		
		$resourceRows = array(
			$this->GetResourceRow($reservationId, $resourceId1, $resourceName1),
			$this->GetResourceRow($reservationId, $resourceId2, $resourceName2),
			);
			
		$participantRows = array(
			$this->GetParticipantRow($reservationId, $userId1, $fname1, $lname1, $email1, $ownerLevel),
			$this->GetParticipantRow($reservationId, $userId2, $fname2, $lname2, $email2, $participantLevel),
			$this->GetParticipantRow($reservationId, $userId3, $fname3, $lname3, $email3, $inviteeLevel),
			);
		
		$this->db->SetRow(0, array($reservationRow));
		$this->db->SetRow(1, $resourceRows);
		$this->db->SetRow(2, $participantRows);

		$reservationView = $this->repository->GetReservationForEditing($referenceNumber);
		
		$commands = $this->db->_Commands;
		
		$this->assertEquals(count($commands), 3);
		$this->assertEquals($getReservationForEditingCommand, $commands[0]);
		$this->assertEquals($getReservationResources, $commands[1]);
		$this->assertEquals($getParticpants, $commands[2]);
		
		$expectedView = new ReservationView();
		$expectedView->AdditionalResourceIds = array($resourceId1, $resourceId2);
		$expectedView->Description = $description;
		$expectedView->EndDate = $endDate;
		$expectedView->OwnerId = $ownerId;
		$expectedView->ReferenceNumber = $referenceNumber;
		$expectedView->ReservationId = $reservationId;
		$expectedView->ResourceId = $resourceId;
		$expectedView->ScheduleId = $scheduleId;
		$expectedView->StartDate = $startDate;
		$expectedView->Title = $title;
		$expectedView->RepeatType = $repeatType;
		$expectedView->RepeatInterval = 5;
		$expectedView->SeriesId = $seriesId;
		$expectedView->OwnerFirstName = $ownerFirst;
		$expectedView->OwnerLastName = $ownerLast;
		
		$expectedView->Participants = array(
			new ReservationUserView($userId2, $fname2, $lname2, $email2, $participantLevel),
		);

		$expectedView->Invitees = array(
			new ReservationUserView($userId3, $fname3, $lname3, $email3, $inviteeLevel),
			);
			
		$expectedView->Resources = array(
			new ReservationResourceView($resourceId1, $resourceName1),
			new ReservationResourceView($resourceId2, $resourceName2),
			);
		
		$this->assertEquals($expectedView, $reservationView);
	}
	
	public function testGetsReservationListForDateRangeAndUser()
	{
		$startDate = Date::Parse('2011-01-01');
		$endDate = Date::Parse('2011-01-01');
		$userId = 988;
		
		$referenceNumber1 = "ref1";
		$resource1 = "resource1";
		$start1 = Date::Parse('2011-08-09', 'UTC');
		$end1 = Date::Parse('2011-08-10', 'UTC');
		$resourceId = 929;
		$seriesId = 1000;

		$rows[] = $this->GetReservationListRow($referenceNumber1, $resource1, $start1, $end1, $resourceId, $seriesId);
		$rows[] = $this->GetReservationListRow("2", "resource", Date::Now(), Date::Now(), 1, 1);

		$this->db->SetRows($rows);
		
		$expectedCommand = new GetReservationListCommand($startDate, $endDate, $userId, ReservationUserLevel::OWNER);
		
		$reservations = $this->repository->GetReservationList($startDate, $endDate, $userId);
		
		$actualCommand = $this->db->_LastCommand;
		
		$this->assertEquals($expectedCommand, $actualCommand);
		
		$this->assertEquals(count($rows), count($reservations));
		$expectedItem1 = new ReservationItemView($referenceNumber1, $start1, $end1, $resource1, $resourceId, $seriesId);
		$this->assertEquals($expectedItem1, $reservations[0]);
	}
	
	public function testReturnsNullObjectIfNothingFound()
	{
		$referenceNumber = "12345";
		$reservationView = $this->repository->GetReservationForEditing($referenceNumber);
		
		$this->assertEquals(NullReservationView::Instance(), $reservationView);
	}
	
	private function GetParticipantRow($reservationId, $userId, $fname, $lname, $email, $levelId)
	{
		return array(
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId, 
			ColumnNames::USER_ID => $userId,
			ColumnNames::FIRST_NAME => $fname,
			ColumnNames::LAST_NAME => $lname,
			ColumnNames::EMAIL => $email,
			ColumnNames::RESERVATION_USER_LEVEL => $levelId,
			);
	}
	
	private function GetResourceRow($reservationId, $resourceId, $resourceName)
	{
		return array(
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId, 
			ColumnNames::RESOURCE_ID => $resourceId,
			ColumnNames::RESOURCE_NAME => $resourceName,
			);
			
	}
	
	private function GetReservationListRow($referenceNumber, $resourceName, Date $startDate, Date $endDate, $resourceId, $seriesId)
	{
		return array(
			ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::RESOURCE_NAME => $resourceName,
			ColumnNames::RESERVATION_START => $startDate->ToDatabase(),
			ColumnNames::RESERVATION_END => $endDate->ToDatabase(),
			ColumnNames::RESOURCE_ID => $resourceId,
			ColumnNames::SERIES_ID => $seriesId
		);
	}
}
?>