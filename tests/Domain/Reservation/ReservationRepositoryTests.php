<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/ExistingReservationSeriesBuilder.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

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

	public function testAddReservationWithOneUserAndOneResource()
	{
		$seriesId = 100;
		$reservationId = 428;
		$userId = 232;
		$resourceId = 10978;
		$title = 'title';
		$description = 'description';
		$startCst = '2010-02-15 16:30';
		$endCst = '2010-02-16 17:00';
		$duration = DateRange::Create($startCst, $endCst, 'CST');
		$levelId = ReservationUserLevel::OWNER;
		$repeatOptions = new RepeatNone();
		$participantIds = array(2, 9);
		$inviteeIds = array(20, 90);
		$accessory = new ReservationAccessory(928, 3);

		$startUtc = Date::Parse($startCst, 'CST')->ToUtc();
		$endUtc = Date::Parse($endCst, 'CST')->ToUtc();

		$dateCreatedUtc = Date::Parse('2010-01-01 12:14:16', 'UTC');
		Date::_SetNow($dateCreatedUtc);

		$this->db->_ExpectedInsertIds[0] = $seriesId;
		$this->db->_ExpectedInsertIds[1] = $reservationId;

		$userSession = new FakeUserSession();

		$reservation = ReservationSeries::Create(
			$userId,
			new FakeBookableResource($resourceId),
			$title,
			$description,
			$duration,
			$repeatOptions,
			$userSession);

		$repeatType = $repeatOptions->RepeatType();
		$repeatOptionsString = $repeatOptions->ConfigurationString();
		$referenceNumber = $reservation->CurrentInstance()->ReferenceNumber();

		$reservation->ChangeParticipants($participantIds);
		$reservation->ChangeInvitees($inviteeIds);
		$reservation->AddAccessory($accessory);

		$this->repository->Add($reservation);

		$insertReservationSeries = new AddReservationSeriesCommand(
			$dateCreatedUtc,
			$title,
			$description,
			$repeatType,
			$repeatOptionsString,
			ReservationTypes::Reservation,
			ReservationStatus::Created,
			$userId);

		$insertReservation = new AddReservationCommand(
			$startUtc,
			$endUtc,
			$referenceNumber,
			$seriesId);

		$insertReservationResource = new AddReservationResourceCommand(
			$seriesId,
			$resourceId,
			ResourceLevel::Primary);

		$insertReservationUser = $this->GetAddUserCommand(
			$reservationId,
			$userId,
			$levelId);

		$insertReservationAccessory = new AddReservationAccessoryCommand($accessory->AccessoryId, $accessory->QuantityReserved, $seriesId);

		$insertParticipant1 = $this->GetAddUserCommand($reservationId, $participantIds[0], ReservationUserLevel::PARTICIPANT);
		$insertParticipant2 = $this->GetAddUserCommand($reservationId, $participantIds[1], ReservationUserLevel::PARTICIPANT);

		$insertInvitee1 = $this->GetAddUserCommand($reservationId, $inviteeIds[0], ReservationUserLevel::INVITEE);
		$insertInvitee2 = $this->GetAddUserCommand($reservationId, $inviteeIds[1], ReservationUserLevel::INVITEE);

		$this->assertEquals(9, count($this->db->_Commands));

		$this->assertEquals($insertReservationSeries, $this->db->_Commands[0]);
		$this->assertEquals($insertReservationResource, $this->db->_Commands[1]);
		$this->assertTrue($this->db->ContainsCommand($insertReservation));
		$this->assertTrue($this->db->ContainsCommand($insertReservationUser));
		$this->assertTrue($this->db->ContainsCommand($insertParticipant1));
		$this->assertTrue($this->db->ContainsCommand($insertParticipant2));
		$this->assertTrue($this->db->ContainsCommand($insertInvitee1));
		$this->assertTrue($this->db->ContainsCommand($insertInvitee2));
		$this->assertTrue($this->db->ContainsCommand($insertReservationAccessory));
	}

	public function testRepeatedDatesAreSaved()
	{
		$reservationSeriesId = 109;
		$reservationId = 918;
		$repeatId1 = 919;
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

		$duration = new TestDateRange();

		$repeats = $this->getMock('IRepeatOptions');

		$repeats->expects($this->once())
				->method('GetDates')
				->with($this->anything())
				->will($this->returnValue($dates));

		$userSession = new FakeUserSession();

		$reservation = ReservationSeries::Create(1, new FakeBookableResource(1), null, null, $duration, $repeats, $userSession);

		$this->db->_ExpectedInsertIds[0] = $reservationSeriesId;
		$this->db->_ExpectedInsertIds[1] = $reservationId;
		$this->db->_ExpectedInsertIds[2] = $repeatId1;
		$this->db->_ExpectedInsertIds[3] = $repeatId3;

		$this->repository->Add($reservation);

		$instances = $reservation->Instances();

		foreach ($instances as $instance)
		{
			$insertRepeatCommand = new AddReservationCommand(
				$instance->StartDate()->ToUtc(),
				$instance->EndDate()->ToUtc(),
				$instance->ReferenceNumber(),
				$reservationSeriesId);

			$this->assertTrue(in_array($insertRepeatCommand, $this->db->_Commands), "command $insertRepeatCommand not found");
		}
	}

	public function testCanAddAdditionalResources()
	{
		$seriesId = 999;
		$id1 = 1;
		$id2 = 2;

		$reservation = new TestReservationSeries();
		$reservation->WithResource(new FakeBookableResource(837));
		$reservation->AddResource(new FakeBookableResource($id1));
		$reservation->AddResource(new FakeBookableResource($id2));

		$this->db->_ExpectedInsertId = $seriesId;

		$this->repository->Add($reservation);

		$insertResource1 = new AddReservationResourceCommand($seriesId, $id1, ResourceLevel::Additional);
		$insertResource2 = new AddReservationResourceCommand($seriesId, $id2, ResourceLevel::Additional);

		$this->assertTrue(in_array($insertResource1, $this->db->_Commands));
		$this->assertTrue(in_array($insertResource2, $this->db->_Commands));
	}

	public function testLoadByIdFullyHydratesReservationSeriesObject()
	{
		$seriesId = 10;
		$reservationId = 1;
		$referenceNumber = 'currentInstanceRefNum';
		$ownerId = 10;
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
		$terminationDateString = '2010-01-20 12:30:00';
		$terminationDate = Date::FromDatabase($terminationDateString);
		$repeatOptions = new RepeatDaily($interval, $terminationDate);

		$instance1Invitees = array(1, 2, 3);
		$instance1Participants = array(4, 5);
		$instance2Invitees = array(6);
		$instance2Participants = array(7, 8, 9);

		$resourceName = 'primary resource';
		$location = 'l';
		$contact = 'c';
		$notes = 'notes';
		$minLength = '3:00';
		$maxLength = null;
		$autoAssign = true;
		$requiresApproval = false;
		$allowMultiDay = true;
		$maxParticipants = 100;
		$minNotice = '2:10';
		$maxNotice = null;
		$statusId = ReservationStatus::Pending;
		$accessoryId1 = 8111;
		$accessoryId2 = 8222;
		$quantity1 = 11;
		$quantity2 = 22;

		$expected = new ExistingReservationSeries();
		$expected->WithId($seriesId);
		$expected->WithOwner($ownerId);
		$expected->WithPrimaryResource(new BookableResource($resourceId, $resourceName, $location, $contact, $notes, $minLength, $maxLength, $autoAssign, $requiresApproval, $allowMultiDay, $maxParticipants, $minNotice, $maxNotice, null, $scheduleId));
		$expected->WithTitle($title);
		$expected->WithDescription($description);
		$expected->WithResource(new BookableResource($resourceId1, $resourceName, $location, $contact, $notes, $minLength, $maxLength, $autoAssign, $requiresApproval, $allowMultiDay, $maxParticipants, $minNotice, $maxNotice, null, $scheduleId));
		$expected->WithResource(new BookableResource($resourceId2, $resourceName, $location, $contact, $notes, $minLength, $maxLength, $autoAssign, $requiresApproval, $allowMultiDay, $maxParticipants, $minNotice, $maxNotice, null, $scheduleId));
		$expected->WithRepeatOptions($repeatOptions);
		$expected->WithStatus($statusId);
		$expected->WithAccessory(new ReservationAccessory($accessoryId1, $quantity1));
		$expected->WithAccessory(new ReservationAccessory($accessoryId2, $quantity2));

		$instance1 = new Reservation($expected, $duration->AddDays(10));
		$instance1->SetReferenceNumber('instance1');
		$instance1->SetReservationId(909);
		$instance1->WithInvitees($instance1Invitees);
		$instance1->WithParticipants($instance1Participants);

		$instance2 = new Reservation($expected, $duration->AddDays(20));
		$instance2->SetReferenceNumber('instance2');
		$instance2->SetReservationId(1909);
		$instance2->WithInvitees($instance2Invitees);
		$instance2->WithParticipants($instance2Participants);

		$expected->WithInstance($instance1);
		$expected->WithInstance($instance2);

		$expectedInstance = new Reservation($expected, $duration);
		$expectedInstance->SetReferenceNumber($referenceNumber);
		$expectedInstance->SetReservationId($reservationId);
		$expected->WithCurrentInstance($expectedInstance);

		$reservationRow = new ReservationRow(
			$reservationId,
			$begin,
			$end,
			$title,
			$description,
			$repeatType,
			$repeatOptions->ConfigurationString(),
			$referenceNumber,
			$seriesId,
			$ownerId,
			$statusId
		);

		$reservationInstanceRow = new ReservationInstanceRow($seriesId);
		$reservationInstanceRow
				->WithInstance($instance1->ReservationId(), $instance1->ReferenceNumber(), $instance1->Duration())
				->WithInstance($instance2->ReservationId(), $instance2->ReferenceNumber(), $instance2->Duration())
				->WithInstance($reservationId, $expectedInstance->ReferenceNumber(), $expectedInstance->Duration());

		$reservationResourceRow = new ReservationResourceRow($reservationId, $resourceName, $location, $contact, $notes, $minLength, $maxLength, $autoAssign, $requiresApproval, $allowMultiDay, $maxParticipants, $minNotice, $maxNotice, $scheduleId);
		$reservationResourceRow
				->WithPrimary($resourceId)
				->WithAdditional($resourceId1)
				->WithAdditional($resourceId2);

		$reservationUserRow = new ReservationUserRow();
		$reservationUserRow
				->WithParticipants($instance1, $instance1Participants)
				->WithParticipants($instance2, $instance2Participants)
				->WithInvitees($instance1, $instance1Invitees)
				->WithInvitees($instance2, $instance2Invitees);

		$reservationAccessoryRow = new ReservationAccessoryRow();
			$reservationAccessoryRow->WithAccessory($accessoryId1, $quantity1)
				->WithAccessory($accessoryId2, $quantity2);

		$this->db->SetRow(0, $reservationRow->Rows());
		$this->db->SetRow(1, $reservationInstanceRow->Rows());
		$this->db->SetRow(2, $reservationResourceRow->Rows());
		$this->db->SetRow(3, $reservationUserRow->Rows());
		$this->db->SetRow(4, $reservationAccessoryRow->Rows());

		$actualReservation = $this->repository->LoadById($reservationId);

		$this->assertEquals($expected, $actualReservation);

		$getReservation = new GetReservationByIdCommand($reservationId);
		$getInstances = new GetReservationSeriesInstances($seriesId);
		$getResources = new GetReservationResourcesCommand($seriesId);
		$getParticipants = new GetReservationSeriesParticipantsCommand($seriesId);
		$getAccessories = new GetReservationAccessoriesCommand($seriesId);

		$this->assertTrue(in_array($getReservation, $this->db->_Commands));
		$this->assertTrue(in_array($getInstances, $this->db->_Commands));
		$this->assertTrue(in_array($getResources, $this->db->_Commands));
		$this->assertTrue(in_array($getParticipants, $this->db->_Commands));
		$this->assertTrue(in_array($getAccessories, $this->db->_Commands));
	}

	public function testChangingOnlySharedInformationForFullSeriesJustUpdatesSeriesTable()
	{
		$userId = 10;
		$title = "new title";
		$description = "new description";

		$builder = new ExistingReservationSeriesBuilder();
		$existingReservation = $builder->Build();

		$existingReservation->Update($userId, $existingReservation->Resource(), $title, $description, new FakeUserSession());
		$repeatOptions = $existingReservation->RepeatOptions();
		$repeatType = $repeatOptions->RepeatType();
		$repeatConfiguration = $repeatOptions->ConfigurationString();

		$this->repository->Update($existingReservation);

		$updateSeriesCommand = new UpdateReservationSeriesCommand(
			$existingReservation->SeriesId(),
			$title,
			$description,
			$repeatType,
			$repeatConfiguration,
			Date::Now(),
			$existingReservation->StatusId(),
			$userId);
		$this->assertEquals(1, count($this->db->_Commands));
		$this->assertEquals($updateSeriesCommand, $this->db->_Commands[0]);
	}

	public function testBranchedSingleInstance()
	{
		$seriesId = 10909;
		$userId = 10;
		$resourceId = 11;
		$title = "new title";
		$description = "new description";
		$expectedRepeat = new RepeatNone();
		$referenceNumber = 'ref number current';

		$currentReservation = new TestReservation($referenceNumber, new TestDateRange());

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithRequiresNewSeries(true);
		$builder->WithRepeatOptions($expectedRepeat);
		$builder->WithCurrentInstance($currentReservation);

		$existingReservation = $builder->BuildTestVersion();
		$existingReservation->Update($userId, new FakeBookableResource($resourceId), $title, $description, new FakeUserSession());

		$this->db->_ExpectedInsertId = $seriesId;

		$this->repository->Update($existingReservation);

		$addNewSeriesCommand = new AddReservationSeriesCommand(
			Date::Now(),
			$title,
			$description,
			$expectedRepeat->RepeatType(),
			$expectedRepeat->ConfigurationString(),
			ReservationTypes::Reservation,
			ReservationStatus::Created,
			$userId);

		$updateReservationCommand = $this->GetUpdateReservationCommand($seriesId, $currentReservation);

		$this->assertTrue(in_array($addNewSeriesCommand, $this->db->_Commands));
		$this->assertTrue(in_array($updateReservationCommand, $this->db->_Commands));
	}

	public function testBranchedWithMovedAndAddedAndRemovedInstances()
	{
		$newSeriesId = 10910;
		$newInstanceId1 = 2827;
		$newInstanceId2 = 2828;
		$userId = 10;
		$resourceId = 11;
		$title = "new title";
		$description = "new description";

		$dateRange = DateRange::Create('2010-01-10 05:30:00', '2010-01-10 08:30:00', 'UTC');
		$existingInstance1 = new TestReservation('123', $dateRange->AddDays(1));
		$existingInstance2 = new TestReservation('223', $dateRange->AddDays(2));
		$newInstance1 = new TestReservation('323', $dateRange->AddDays(3));
		$newInstance2 = new TestReservation('423', $dateRange->AddDays(4));
		$removedInstance1 = new TestReservation('523', $dateRange->AddDays(5));
		$removedInstance2 = new TestReservation('623', $dateRange->AddDays(6));
		$currentInstance = new TestReservation('999', $dateRange);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithEvent(new InstanceAddedEvent($newInstance1, $builder->series));
		$builder->WithEvent(new InstanceAddedEvent($newInstance2, $builder->series));
		$builder->WithEvent(new InstanceRemovedEvent($removedInstance1, $builder->series));
		$builder->WithEvent(new InstanceRemovedEvent($removedInstance2, $builder->series));
		$builder->WithEvent(new SeriesBranchedEvent($builder->series));
		$builder->WithRequiresNewSeries(true);
		$builder->WithInstance($existingInstance1);
		$builder->WithInstance($existingInstance2);
		$builder->WithCurrentInstance($currentInstance);

		$existingReservation = $builder->BuildTestVersion();
		$existingReservation->Update($userId, new FakeBookableResource($resourceId), $title, $description, new FakeUserSession());

		$expectedRepeat = $existingReservation->RepeatOptions();

		$this->db->_ExpectedInsertIds[] = $newSeriesId;
		$this->db->_ExpectedInsertIds[] = $newInstanceId1;
		$this->db->_ExpectedInsertIds[] = $newInstanceId2;

		$this->repository->Update($existingReservation);

		$addNewSeriesCommand = new AddReservationSeriesCommand(
			Date::Now(),
			$title,
			$description,
			$expectedRepeat->RepeatType(),
			$expectedRepeat->ConfigurationString(),
			ReservationTypes::Reservation,
			ReservationStatus::Created,
			$userId);

		$updateReservationCommand1 = $this->GetUpdateReservationCommand($newSeriesId, $existingInstance1);
		$updateReservationCommand2 = $this->GetUpdateReservationCommand($newSeriesId, $existingInstance2);
		$updateReservationCommand3 = $this->GetUpdateReservationCommand($newSeriesId, $currentInstance);

		$addReservationCommand1 = $this->GetAddReservationCommand($newSeriesId, $newInstance1);
		$addReservationCommand2 = $this->GetAddReservationCommand($newSeriesId, $newInstance2);

		$insertReservationUser1 = $this->GetAddUserCommand($newInstanceId1, $userId, ReservationUserLevel::OWNER);
		$insertReservationUser2 = $this->GetAddUserCommand($newInstanceId2, $userId, ReservationUserLevel::OWNER);

		$removeReservationCommand1 = new RemoveReservationCommand($removedInstance1->ReferenceNumber());
		$removeReservationCommand2 = new RemoveReservationCommand($removedInstance2->ReferenceNumber());

		$this->assertEquals($addNewSeriesCommand, $this->db->_Commands[0]);

		$commands = $this->db->GetCommandsOfType('UpdateReservationCommand');
		$this->assertEquals(3, count($commands));

		$addUserCommands = $this->db->GetCommandsOfType('AddReservationUserCommand');
		$this->assertEquals(2, count($addUserCommands));

		$this->assertTrue(in_array($updateReservationCommand1, $this->db->_Commands));
		$this->assertTrue(in_array($updateReservationCommand2, $this->db->_Commands));
		$this->assertTrue(in_array($updateReservationCommand3, $this->db->_Commands));

		$this->assertTrue(in_array($addReservationCommand1, $this->db->_Commands));
		$this->assertTrue(in_array($addReservationCommand2, $this->db->_Commands));

		$this->assertTrue(in_array($insertReservationUser1, $this->db->_Commands));
		$this->assertTrue(in_array($insertReservationUser2, $this->db->_Commands));

		$this->assertTrue(in_array($removeReservationCommand1, $this->db->_Commands));
		$this->assertTrue(in_array($removeReservationCommand2, $this->db->_Commands));
	}

	public function testWithUpdatedInstances()
	{
		$seriesId = 3929;
		$dateRange = new TestDateRange();

		$instance1 = new TestReservation('323', $dateRange->AddDays(3));
		$instance2 = new TestReservation('423', $dateRange->AddDays(4));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithEvent(new InstanceUpdatedEvent($instance1, $builder->series));
		$builder->WithEvent(new InstanceUpdatedEvent($instance2, $builder->series));
		$series = $builder->BuildTestVersion();
		$series->WithId($seriesId);
		$this->repository->Update($series);

		$updateReservationCommand1 = $this->GetUpdateReservationCommand($seriesId, $instance1);
		$updateReservationCommand2 = $this->GetUpdateReservationCommand($seriesId, $instance2);

		$commands = $this->db->GetCommandsOfType('UpdateReservationCommand');

		$this->assertEquals(2, count($commands));
		$this->assertTrue(in_array($updateReservationCommand1, $this->db->_Commands));
		$this->assertTrue(in_array($updateReservationCommand2, $this->db->_Commands));
	}

	public function testDeleteSeries()
	{
		$seriesId = 981;
		$eventSeries = new ExistingReservationSeries();
		$eventSeries->WithId($seriesId);

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithEvent(new SeriesDeletedEvent($eventSeries));
		$series = $builder->BuildTestVersion();
		$series->WithId($seriesId);

		$this->repository->Delete($series);

		$deleteSeriesCommand = new DeleteSeriesCommand($eventSeries->SeriesId());

		$this->assertEquals(1, count($this->db->_Commands));
		$this->assertTrue(in_array($deleteSeriesCommand, $this->db->_Commands));
	}

	public function testDeleteInstances()
	{
		$seriesId = 981;
		$instance1 = new TestReservation("ref1");
		$instance2 = new TestReservation("ref2");

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithEvent(new InstanceRemovedEvent($instance1, $builder->series));
		$builder->WithEvent(new InstanceRemovedEvent($instance2, $builder->series));
		$series = $builder->BuildTestVersion();
		$series->WithId($seriesId);

		$this->repository->Delete($series);

		$deleteInstance1 = new RemoveReservationCommand($instance1->ReferenceNumber());
		$deleteInstance2 = new RemoveReservationCommand($instance2->ReferenceNumber());

		$this->assertEquals(2, count($this->db->_Commands));
		$this->assertTrue(in_array($deleteInstance1, $this->db->_Commands));
		$this->assertTrue(in_array($deleteInstance2, $this->db->_Commands));
	}

	public function testChangesParticipantsForAllInstances()
	{
		$instanceId1 = 100;
		$reservation1 = new TestReservation(null, null, $instanceId1);
		$reservation1->WithParticipants(array(1, 2, 3));

		$instanceId2 = 101;
		$reservation2 = new TestReservation(null, null, $instanceId2);
		$reservation2->WithParticipants(array(2, 3));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($reservation1);
		$builder->WithInstance($reservation2);

		$series = $builder->BuildTestVersion();
		$series->ChangeParticipants(array(3, 4));

		$this->repository->Update($series);

		$this->assertTrue($this->db->ContainsCommand($this->GetRemoveUserCommand($instanceId1, 1)));
		$this->assertTrue($this->db->ContainsCommand($this->GetRemoveUserCommand($instanceId1, 2)));
		$this->assertTrue($this->db->ContainsCommand($this->GetAddUserCommand($instanceId1, 4, ReservationUserLevel::PARTICIPANT)));

		$this->assertTrue($this->db->ContainsCommand($this->GetRemoveUserCommand($instanceId2, 2)));
		$this->assertTrue($this->db->ContainsCommand($this->GetAddUserCommand($instanceId2, 4, ReservationUserLevel::PARTICIPANT)));
	}

	public function testChangesInviteesForAllInstances()
	{
		$instanceId1 = 100;
		$reservation1 = new TestReservation(null, null, $instanceId1);
		$reservation1->WithInvitees(array(1, 2, 3));

		$instanceId2 = 101;
		$reservation2 = new TestReservation(null, null, $instanceId2);
		$reservation2->WithInvitees(array(2, 3));

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithInstance($reservation1);
		$builder->WithInstance($reservation2);

		$series = $builder->BuildTestVersion();
		$series->ChangeInvitees(array(3, 4));

		$this->repository->Update($series);

		$this->assertTrue($this->db->ContainsCommand($this->GetRemoveUserCommand($instanceId1, 1)));
		$this->assertTrue($this->db->ContainsCommand($this->GetRemoveUserCommand($instanceId1, 2)));
		$this->assertTrue($this->db->ContainsCommand($this->GetAddUserCommand($instanceId1, 4, ReservationUserLevel::INVITEE)));

		$this->assertTrue($this->db->ContainsCommand($this->GetRemoveUserCommand($instanceId2, 2)));
		$this->assertTrue($this->db->ContainsCommand($this->GetAddUserCommand($instanceId2, 4, ReservationUserLevel::INVITEE)));
	}

	public function testAddsResources()
	{
		$addedId = 29;
		$removedId = 28;

		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->BuildTestVersion();
		$series->WithResource(new FakeBookableResource($removedId));
		$series->ChangeResources(array(new FakeBookableResource($addedId)));

		$this->repository->Update($series);

		$addCommand = new AddReservationResourceCommand($series->SeriesId(), $addedId, ResourceLevel::Additional);
		$removeCommand = new RemoveReservationResourceCommand($series->SeriesId(), $removedId);

		$this->assertTrue($this->db->ContainsCommand($addCommand));
		$this->assertTrue($this->db->ContainsCommand($removeCommand));
	}

	public function testChangesAccessories()
	{
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->BuildTestVersion();
		$series->WithAccessory(new ReservationAccessory(1, 1));
		$series->ChangeAccessories(array(new ReservationAccessory(2, 2)));

		$seriesId = $series->SeriesId();
		$this->repository->Update($series);

		$addCommand = new AddReservationAccessoryCommand(2, 2, $seriesId);
		$removeCommand = new RemoveReservationAccessoryCommand($seriesId, 1);

		$this->assertTrue($this->db->ContainsCommand($addCommand));
		$this->assertTrue($this->db->ContainsCommand($removeCommand));
	}

	private function GetUpdateReservationCommand($expectedSeriesId, Reservation $expectedInstance)
	{
		return new UpdateReservationCommand(
			$expectedInstance->ReferenceNumber(),
			$expectedSeriesId,
			$expectedInstance->StartDate(),
			$expectedInstance->EndDate());
	}

	private function GetAddReservationCommand($expectedSeriesId, Reservation $expectedInstance)
	{
		return new AddReservationCommand(
			$expectedInstance->StartDate(),
			$expectedInstance->EndDate(),
			$expectedInstance->ReferenceNumber(),
			$expectedSeriesId);
	}

	private function GetAddUserCommand($reservationId, $userId, $levelId)
	{
		return new AddReservationUserCommand($reservationId, $userId, $levelId);
	}

	private function GetRemoveUserCommand($reservationId, $userId)
	{
		return new RemoveReservationUserCommand($reservationId, $userId);
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
		$seriesId,
		$ownerId,
		$statusId
	)
	{
		$this->row = array(
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId,
			ColumnNames::RESERVATION_START => $startDate,
			ColumnNames::RESERVATION_END => $endDate,
			ColumnNames::RESERVATION_TITLE => $title,
			ColumnNames::RESERVATION_DESCRIPTION => $description,
			ColumnNames::RESERVATION_TYPE => ReservationTypes::Reservation,
			ColumnNames::REPEAT_TYPE => $repeatType,
			ColumnNames::REPEAT_OPTIONS => $repeatOptions,
			ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::SERIES_ID => $seriesId,
			ColumnNames::RESERVATION_OWNER => $ownerId,
			ColumnNames::RESERVATION_STATUS => $statusId
		);
	}
}

class ReservationInstanceRow
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

	/**
	 * @param int $instanceId
	 * @param string $referenceNum
	 * @param DateRange $duration
	 * @return ReservationInstanceRow
	 */
	public function WithInstance($instanceId, $referenceNum, $duration)
	{
		$this->rows[] = array(
			ColumnNames::SERIES_ID => $this->seriesId,
			ColumnNames::RESERVATION_INSTANCE_ID => $instanceId,
			ColumnNames::REFERENCE_NUMBER => $referenceNum,
			ColumnNames::RESERVATION_START => $duration->GetBegin()->ToDatabase(),
			ColumnNames::RESERVATION_END => $duration->GetEnd()->ToDatabase(),
		);

		return $this;
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

	public function __construct($seriesId,
		$resourceName = null,
		$location = null,
		$contact = null,
		$notes = null,
		$minLength = null,
		$maxLength = null,
		$autoAssign = null,
		$requiresApproval = null,
		$allowMultiDay = null,
		$maxParticipants = null,
		$minNotice = null,
		$maxNotice = null,
		$scheduleId = null)
	{
		$this->seriesId = $seriesId;
		$this->resourceName = $resourceName;
		$this->location = $location;
		$this->contact = $contact;
		$this->notes = $notes;
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
		$this->autoAssign = $autoAssign;
		$this->requiresApproval = $requiresApproval;
		$this->allowMultiDay = $allowMultiDay;
		$this->maxParticipants = $maxParticipants;
		$this->minNotice = $minNotice;
		$this->maxNotice = $maxNotice;
		$this->scheduleId = $scheduleId;
        $this->description = null;
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
		$this->rows[] = array(
			ColumnNames::SERIES_ID => $this->seriesId,
			ColumnNames::RESOURCE_ID => $resourceId,
			ColumnNames::RESOURCE_LEVEL_ID => $levelId,
			ColumnNames::RESOURCE_NAME => $this->resourceName,
			ColumnNames::RESOURCE_DESCRIPTION => $this->description,
			ColumnNames::RESOURCE_LOCATION => $this->location,
			ColumnNames::RESOURCE_CONTACT => $this->contact,
			ColumnNames::RESOURCE_NOTES => $this->notes,
			ColumnNames::RESOURCE_MINDURATION => $this->minLength,
			ColumnNames::RESOURCE_MAXDURATION => $this->maxLength,
			ColumnNames::RESOURCE_AUTOASSIGN => $this->autoAssign,
			ColumnNames::RESOURCE_REQUIRES_APPROVAL => $this->requiresApproval,
			ColumnNames::RESOURCE_ALLOW_MULTIDAY => $this->allowMultiDay,
			ColumnNames::RESOURCE_MAX_PARTICIPANTS => $this->maxParticipants,
			ColumnNames::RESOURCE_MINNOTICE => $this->minNotice,
			ColumnNames::RESOURCE_MAXNOTICE => $this->maxNotice,
			ColumnNames::SCHEDULE_ID => $this->scheduleId,
		);
	}
}

class ReservationUserRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	private function AddRow($referenceNumber, $userId, $levelId)
	{
		$this->rows[] = array(ColumnNames::REFERENCE_NUMBER => $referenceNumber,
							  ColumnNames::USER_ID => $userId,
							  ColumnNames::RESERVATION_USER_LEVEL => $levelId);
	}

	/**
	 * @param Reservation $instance
	 * @param array|int[] $participantIds
	 * @return ReservationUserRow
	 */
	public function WithParticipants($instance, $participantIds)
	{
		foreach ($participantIds as $id)
		{
			$this->AddRow($instance->ReferenceNumber(), $id, ReservationUserLevel::PARTICIPANT);
		}
		return $this;
	}

	/**
	 * @param Reservation $instance
	 * @param array|int[] $inviteeIds
	 * @return ReservationUserRow
	 */
	public function WithInvitees($instance, $inviteeIds)
	{
		foreach ($inviteeIds as $id)
		{
			$this->AddRow($instance->ReferenceNumber(), $id, ReservationUserLevel::INVITEE);
		}
		return $this;
	}
}


class ReservationAccessoryRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function WithAccessory($accessoryId, $quantity, $name = null)
	{
		$this->rows[] = array(ColumnNames::ACCESSORY_ID => $accessoryId, ColumnNames::QUANTITY => $quantity, ColumnNames::ACCESSORY_NAME => $name);
		
		return $this;
	}
}
?>