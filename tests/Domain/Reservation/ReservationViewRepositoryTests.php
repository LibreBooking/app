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
		
		$resourceId1 = 88;
		$resourceId2 = 99;
		
		$userId1 = 87;
		$userId2 = 97;
		
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
		);
		
		$resourceRows = array(
			array(ColumnNames::RESERVATION_INSTANCE_ID => $reservationId, ColumnNames::RESOURCE_ID => $resourceId1),
			array(ColumnNames::RESERVATION_INSTANCE_ID => $reservationId, ColumnNames::RESOURCE_ID => $resourceId2)
			);
			
		$participantRows = array(
			array(ColumnNames::RESERVATION_INSTANCE_ID => $reservationId, ColumnNames::USER_ID => $userId1),
			array(ColumnNames::RESERVATION_INSTANCE_ID => $reservationId, ColumnNames::USER_ID => $userId2)
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
		$expectedView->ParticipantIds = array($userId1, $userId2);
		$expectedView->ReferenceNumber = $referenceNumber;
		$expectedView->ReservationId = $reservationId;
		$expectedView->ResourceId = $resourceId;
		$expectedView->ScheduleId = $scheduleId;
		$expectedView->StartDate = $startDate;
		$expectedView->Title = $title;
		$expectedView->RepeatType = $repeatType;
		$expectedView->RepeatInterval = 5;
		$expectedView->SeriesId = $seriesId;
		
		$this->assertEquals($expectedView, $reservationView);
	}
	
	public function testReturnsNullObjectIfNothingFound()
	{
		$referenceNumber = "12345";
		$reservationView = $this->repository->GetReservationForEditing($referenceNumber);
		
		$this->assertEquals(NullReservationView::Instance(), $reservationView);
	}
}
?>