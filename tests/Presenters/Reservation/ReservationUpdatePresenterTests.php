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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationUpdatePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationUpdatePage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationUpdatePresenterTests extends TestBase
{	
	private $userId;
	
	/**
	 * @var UserSession
	 */
	private $user;
	
	/**
	 * @var FakeReservationUpdatePage
	 */
	private $page;
	
	/**
	 * @var IUpdateReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IReservationHandler
	 */
	private $handler;


	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var ReservationUpdatePresenter
	 */
	private $presenter;
	
	public function setup()
	{
		parent::setup();
		
		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;
		
		$this->persistenceService = $this->getMock('IUpdateReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->page = new FakeReservationUpdatePage();
		
		$this->presenter = new ReservationUpdatePresenter(
								$this->page, 
								$this->persistenceService, 
								$this->handler,
								$this->resourceRepository);
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testLoadsExistingReservationAndUpdatesData()
	{
		$seriesId = 109809;
		$expectedSeries = new ExistingReservationSeries();	
		$currentDuration = new DateRange(Date::Now()->AddDays(1), Date::Now()->AddDays(2), 'UTC');
		$removedResourceId = 190;

		$resource = new FakeBookableResource(1);
		$additionalId1 = $this->page->resourceIds[0];
		$additionalId2 = $this->page->resourceIds[1];
		$additional1 = new FakeBookableResource($additionalId1);
		$additional2 = new FakeBookableResource($additionalId2);

		$reservation = new Reservation($expectedSeries, $currentDuration);		
		$expectedSeries->WithId($seriesId);
		$expectedSeries->WithCurrentInstance($reservation);
		$expectedSeries->WithPrimaryResource($resource);
		$expectedSeries->WithResource(new FakeBookableResource($removedResourceId));
		$expectedSeries->WithAttribute(new AttributeValue(100, 'to be removed'));

		$reservationId = $this->page->reservationId;
		
		$timezone = $this->user->Timezone;
		
		$this->persistenceService->expects($this->once())
			->method('LoadByInstanceId')
			->with($this->equalTo($reservationId))
			->will($this->returnValue($expectedSeries));

		$this->resourceRepository->expects($this->at(0))
			->method('LoadById')
			->with($this->equalTo($this->page->resourceId))
			->will($this->returnValue($resource));

		$this->resourceRepository->expects($this->at(1))
			->method('LoadById')
			->with($this->equalTo($additionalId1))
			->will($this->returnValue($additional1));

		$this->resourceRepository->expects($this->at(2))
			->method('LoadById')
			->with($this->equalTo($additionalId2))
			->will($this->returnValue($additional2));

		$this->page->repeatOptions = new RepeatDaily(1, Date::Now());
			
		$expectedDuration = DateRange::Create(
			$this->page->GetStartDate() . " " . $this->page->GetStartTime(),
			$this->page->GetEndDate() . " " . $this->page->GetEndTime(),
			$timezone);

		$attachment = new FakeUploadedFile();
		$this->page->attachment = $attachment;

		$existingSeries = $this->presenter->BuildReservation();

		$expectedAccessories = array(new ReservationAccessory(1, 2));
		$expectedAttributes = array(1 => new AttributeValue(1, 'something'));

		$this->assertEquals($seriesId, $existingSeries->SeriesId());
		$this->assertEquals($this->page->seriesUpdateScope, $existingSeries->SeriesUpdateScope());
		$this->assertEquals($this->page->title, $existingSeries->Title());
		$this->assertEquals($this->page->description, $existingSeries->Description());
		$this->assertEquals($this->page->userId, $existingSeries->UserId());
		$this->assertEquals($resource, $existingSeries->Resource());
		$this->assertEquals($this->page->repeatOptions, $existingSeries->RepeatOptions());
		$this->assertEquals(array($additional1, $additional2), $existingSeries->AdditionalResources());
		$this->assertEquals($this->page->participants, $existingSeries->CurrentInstance()->AddedParticipants());
		$this->assertEquals($this->page->invitees, $existingSeries->CurrentInstance()->AddedInvitees());
		$this->assertTrue($expectedDuration->Equals($existingSeries->CurrentInstance()->Duration()), "Expected: $expectedDuration Actual: {$existingSeries->CurrentInstance()->Duration()}");
		$this->assertEquals($this->user, $expectedSeries->BookedBy());
		$this->assertEquals($expectedAccessories, $existingSeries->Accessories());
		$this->assertEquals($expectedAttributes, $existingSeries->AttributeValues());
		$expectedAttachment = ReservationAttachment::Create($attachment->OriginalName(), $attachment->MimeType(), $attachment->Size(), $attachment->Contents(), $attachment->Extension(), $seriesId);
		$this->assertEquals($expectedAttachment, $expectedSeries->AddedAttachment());
	}

	public function testUsesFirstAdditionalResourceIfPrimaryIsRemoved()
	{
		$reservationId = $this->page->reservationId;
		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithPrimaryResource(new FakeBookableResource(100));
		$expectedSeries = $builder->Build();

		$additionalId = 5;
		$this->page->resourceId = null;
		$this->page->resourceIds = array($additionalId);

		$resource = new FakeBookableResource($additionalId);

		$this->persistenceService->expects($this->once())
			->method('LoadByInstanceId')
			->with($this->equalTo($reservationId))
			->will($this->returnValue($expectedSeries));
		
		$this->resourceRepository->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($additionalId))
			->will($this->returnValue($resource));

		$existingSeries = $this->presenter->BuildReservation();

		$this->assertEquals($resource, $existingSeries->Resource());
	}
	
	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistenceAndNotification()
	{
		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);
		
		$this->handler->expects($this->once())
				->method('Handle')
				->with($this->equalTo($series), $this->isInstanceOf('FakeReservationUpdatePage'))
				->will($this->returnValue(true));

		$this->presenter->HandleReservation($series);
		
		$this->assertEquals($instance->ReferenceNumber(), $this->page->referenceNumber);
	}
}

class FakeReservationUpdatePage extends FakeReservationSavePage implements IReservationUpdatePage
{
	public $reservationId = 100;
	public $seriesUpdateScope = SeriesUpdateScope::FullSeries;

	public function __construct()
	{
	    parent::__construct();
	}
	
	public function GetReservationId()
	{
		return $this->reservationId;
	}
	
	public function GetSeriesUpdateScope()
	{
		return $this->seriesUpdateScope;
	}
}
?>