<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	public function setup()
	{
		parent::setup();

		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;

		$this->page = new FakeReservationSavePage();

		$this->persistenceService = $this->getMock('IReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->presenter = new ReservationSavePresenter(
			$this->page,
			$this->persistenceService,
			$this->handler,
			$this->resourceRepository,
			$this->fakeUser);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testCreationBuildsReservationFromPageData()
	{
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

		$roFactory = new RepeatOptionsFactory();
		$repeatOptions = $roFactory->CreateFromComposite($this->page, $timezone);

		$participants = $this->page->GetParticipants();
		$invitees = $this->page->GetInvitees();
		$attachment = new FakeUploadedFile();
		$this->page->attachment = $attachment;

		$resource = new FakeBookableResource($resourceId, 'r1');
		$additionalResource1 = new FakeBookableResource($additionalResources[0], 'r2');
		$additionalResource2 = new FakeBookableResource($additionalResources[1], 'r3');

		$accessories = array();
		foreach ($pageAccessories as $pa)
		{
			$accessories[] = new ReservationAccessory($pa->Id, $pa->Quantity, $pa->Name);
		}

		$expectedAttributes = array();
		foreach ($pageAttributes as $attr)
		{
			$expectedAttributes[] = new AttributeValue($attr->Id, $attr->Value);
		}

		$startReminder = new ReservationReminder($this->page->GetStartReminderValue(), $this->page->GetStartReminderInterval());
		$endReminder = new ReservationReminder($this->page->GetEndReminderValue(), $this->page->GetEndReminderInterval());

		$this->resourceRepository->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($resourceId))
				->will($this->returnValue($resource));

		$this->resourceRepository->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($additionalResources[0]))
				->will($this->returnValue($additionalResource1));

		$this->resourceRepository->expects($this->at(2))
				->method('LoadById')
				->with($this->equalTo($additionalResources[1]))
				->will($this->returnValue($additionalResource2));

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
	}
}

?>