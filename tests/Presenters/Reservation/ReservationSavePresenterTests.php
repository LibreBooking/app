<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationSavePresenterTests extends TestBase
{
	/**
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var IReservationSavePage|FakeReservationSavePage
	 */
	private $page;

	/**
	 * @var ReservationSavePresenter
	 */
	private $presenter;

	/**
	 * @var IReservationPersistenceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $persistenceService;

	/**
	 * @var IReservationHandler|PHPUnit_Framework_MockObject_MockObject
	 */
	private $handler;

	/**
	 * @var FakeResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var FakeAccessoryRepository
	 */
	private $accessoryRepository;

	/**
	 * @var FakeScheduleRepository
	 */
	private $scheduleRepository;

	public function setUp(): void
	{
		parent::setup();

		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;

		$this->page = new FakeReservationSavePage();

		$this->persistenceService = $this->createMock('IReservationPersistenceService');
		$this->handler = $this->createMock('IReservationHandler');
		$this->resourceRepository = new FakeResourceRepository();
		$this->accessoryRepository = new FakeAccessoryRepository();
		$this->scheduleRepository = new FakeScheduleRepository();

		$this->presenter = new ReservationSavePresenter(
				$this->page,
				$this->persistenceService,
				$this->handler,
				$this->resourceRepository,
				$this->scheduleRepository,
				$this->accessoryRepository,
				$this->fakeUser);
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testCreationBuildsReservationFromPageData()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, 'true');
		$timezone = $this->user->Timezone;

		$userId = $this->page->GetUserId();
		$resourceId = $this->page->GetResourceId();
		$title = $this->page->GetTitle();
		$description = $this->page->GetDescription();

		$startDate = $this->page->GetStartDate();
		$endDate = $this->page->GetEndDate();
		$startTime = $this->page->GetStartTime();
		$endTime = $this->page->GetEndTime();
		$additionalResources = $this->page->GetResources();
		$pageAccessories = $this->page->GetAccessories();
		$pageAttributes = $this->page->GetAttributes();
		$participatingGuests = array('p1@email.com');
		$this->page->participatingGuests = $participatingGuests;
		$invitedGuests = array('i1@email.com');
		$this->page->invitedGuests = $invitedGuests;

		$roFactory = new RepeatOptionsFactory();
		$repeatOptions = $roFactory->CreateFromComposite($this->page, $timezone);

		$participants = $this->page->GetParticipants();
		$invitees = $this->page->GetInvitees();
		$attachment = new FakeUploadedFile();
		$this->page->attachment = $attachment;

		$resource = new FakeBookableResource($resourceId, 'r1');
		$resource->SetCreditsPerSlot(1);
		$resource->SetPeakCreditsPerSlot(1);
		$additionalResource1 = new FakeBookableResource($additionalResources[0], 'r2');
		$additionalResource2 = new FakeBookableResource($additionalResources[1], 'r3');

		$accessories = array();
		foreach ($pageAccessories as $pa)
		{
			$accessory = new Accessory($pa->Id, "name$pa->Id", 100);
			$this->accessoryRepository->_AccessoryList[$pa->Id] = $accessory;
			$accessories[] = new ReservationAccessory($accessory, $pa->Quantity);
		}

		$expectedAttributes = array();
		foreach ($pageAttributes as $attr)
		{
			$expectedAttributes[] = new AttributeValue($attr->Id, $attr->Value);
		}

		$startReminder = new ReservationReminder($this->page->GetStartReminderValue(), $this->page->GetStartReminderInterval());
		$endReminder = new ReservationReminder($this->page->GetEndReminderValue(), $this->page->GetEndReminderInterval());

		$this->resourceRepository->_ResourceList[$resourceId] = $resource;
		$this->resourceRepository->_ResourceList[$additionalResources[0]] = $additionalResource1;
		$this->resourceRepository->_ResourceList[$additionalResources[1]] = $additionalResource2;

		$fakeScheduleLayout = new FakeScheduleLayout();
		$fakeScheduleLayout->_SlotCount = new SlotCount(1, 2);
		$this->scheduleRepository->_Layout = $fakeScheduleLayout;
		$expectedCredits = 168;

		$duration = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);

		$actualReservation = $this->presenter->BuildReservation();

		$this->assertEquals($userId, $actualReservation->UserId());
		$this->assertEquals($resourceId, $actualReservation->ResourceId());
		$this->assertEquals($title, $actualReservation->Title());
		$this->assertEquals($description, $actualReservation->Description());
		$this->assertEquals($duration, $actualReservation->CurrentInstance()->Duration());
		$this->assertEquals($repeatOptions, $actualReservation->RepeatOptions());
		$this->assertEquals($participants, $actualReservation->CurrentInstance()->AddedParticipants());
		$this->assertEquals($invitees, $actualReservation->CurrentInstance()->AddedInvitees());
		$this->assertEquals($accessories, $actualReservation->Accessories());
		$this->assertTrue(in_array($expectedAttributes[0], $actualReservation->AttributeValues()));
		$expectedAttachment = ReservationAttachment::Create($attachment->OriginalName(), $attachment->MimeType(),
															$attachment->Size(), $attachment->Contents(),
															$attachment->Extension(), 0);
		$this->assertEquals(array($expectedAttachment), $actualReservation->AddedAttachments());
		$this->assertEquals($startReminder, $actualReservation->GetStartReminder());
		$this->assertEquals($endReminder, $actualReservation->GetEndReminder());
		$this->assertEquals($participatingGuests, $actualReservation->CurrentInstance()->AddedParticipatingGuests());
		$this->assertEquals($invitedGuests, $actualReservation->CurrentInstance()->AddedInvitedGuests());
		$this->assertEquals($expectedCredits, $actualReservation->GetCreditsRequired(), '3 credits per slot, 2 day reservation, recurs 28 times');
	}

	public function testHandlingReservationCreationDelegatesToHandler()
	{
		$series = new TestReservationSeries();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);

		$this->handler->expects($this->once())
					  ->method('Handle')
					  ->with($this->equalTo($series), $this->isInstanceOf('FakeReservationSavePage'))
					  ->will($this->returnValue(true));

		$this->presenter->HandleReservation($series);

		$this->assertEquals($instance->ReferenceNumber(), $this->page->referenceNumber);
		$this->assertEquals($series->RequiresApproval(), $this->page->requiresApproval);
	}
}