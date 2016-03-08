<?php
/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ResourceDisplayPresenter.php');
require_once(ROOT_DIR . 'Pages/ResourceDisplayPage.php');

class ResourceDisplayPresenterTests extends TestBase
{
	/**
	 * @var TestResourceDisplayPage
	 */
	private $page;

	/**
	 * @var FakeResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var FakeReservationService
	 */
	private $reservationService;

	/**
	 * @var ResourceDisplayPresenter
	 */
	private $presenter;

	/**
	 * @var FakeAuthorizationService
	 */
	private $authorizationService;

	/**
	 * @var FakeWebAuthentication
	 */
	private $authentication;

	/**
	 * @var FakeScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var DailyLayoutFactory
	 */
	private $dailyLayoutFactory;

	public function setup()
	{
		parent::setup();

		$this->page = new TestResourceDisplayPage();
		$this->resourceRepository = new FakeResourceRepository();
		$this->scheduleRepository = new FakeScheduleRepository();
		$this->reservationService = new FakeReservationService();
		$this->authorizationService = new FakeAuthorizationService();
		$this->authentication = new FakeWebAuthentication();
		$this->dailyLayoutFactory = new DailyLayoutFactory();
		$this->presenter = new ResourceDisplayPresenter($this->page,
														$this->resourceRepository,
														$this->reservationService,
														$this->authorizationService,
														$this->authentication,
														$this->scheduleRepository,
														$this->dailyLayoutFactory);
	}

	public function testShowsLoginIfNotLoggedInAndNoResource()
	{
		$this->fakeServer->UserSession = new NullUserSession();

		$this->presenter->PageLoad();

		$this->assertTrue($this->page->_DisplayLoginCalled);
	}

	public function testSuccessfulLoginLoadsResources()
	{
		$this->page->_Username = 'u';
		$this->page->_Password = 'p';

		$this->resourceRepository->_ResourceList = array(new FakeBookableResource(1), new FakeBookableResource(2));
		$this->authorizationService->_CanEditForResource = true;
		$this->authentication->_ValidateResult = true;

		$this->presenter->Login();

		$this->assertFalse($this->page->_BoundInvalidLogin);
		$this->assertEquals($this->resourceRepository->_ResourceList, $this->page->_BoundResourceList);
	}

	public function testUnsuccessfulLoginBindsError()
	{
		$this->page->_Username = 'u';
		$this->page->_Password = 'p';

		$this->authentication->_ValidateResult = false;

		$this->presenter->Login();

		$this->assertTrue($this->page->_BoundInvalidLogin);
	}

	public function testActivatingResourceTurnsOnDisplay()
	{
		$this->page->_ResourceId = '123';
		$this->authorizationService->_CanEditForResource = true;
		$resource = new FakeBookableResource(1);

		$this->resourceRepository->_Resource = $resource;

		$this->presenter->Activate();

		$this->assertEquals($resource->GetPublicId(), $this->page->_ActivatedResourceId);
		$this->assertEquals($this->resourceRepository->_Resource, $this->resourceRepository->_UpdatedResource);
	}

	public function testDisplaysReservationsIfResourceAllowsDisplay()
	{
		Date::_SetNow(new Date('2016-03-07 11:28', 'UTC'));
		$scheduleId = 123;
		$timezone = 'America/Chicago';

		$publicId = 'publicId';
		$resource = new FakeBookableResource(1);
		$resource->EnableDisplay();
		$resource->SetScheduleId($scheduleId);
		$this->resourceRepository->_Resource = $resource;
		$schedule = new FakeSchedule($scheduleId);
		$schedule->SetTimezone($timezone);
		$this->scheduleRepository->_Schedule = $schedule;
		$this->scheduleRepository->_Layout = new ScheduleLayout($timezone);

		$this->presenter->DisplayResource($publicId);
		$expectedDate = DateRange::Create('2016-03-07', '2016-03-08', 'UTC');

		$this->assertEquals(new DailyLayout($this->reservationService->_ReservationListing,
											$this->scheduleRepository->_Layout), $this->page->_DailyLayout);
		$this->assertEquals($expectedDate, $this->reservationService->_LastDateRange);
		$this->assertEquals(1, $this->reservationService->_LastResourceId);
		$this->assertEquals($resource, $this->page->_BoundResource);
		$this->assertFalse($this->page->_DisplayNotEnabledMessage);

	}

	public function testAvailableNow()
	{
		$now = new Date('2016-03-07 11:00', 'UTC');
		Date::_SetNow($now);
		$scheduleId = 123;
		$timezone = 'America/Chicago';
		$resource = new FakeBookableResource(1);
		$resource->EnableDisplay();
		$this->resourceRepository->_Resource = $resource;
		$schedule = new FakeSchedule($scheduleId);
		$this->scheduleRepository->_Schedule = $schedule;
		$this->scheduleRepository->_Layout = new ScheduleLayout($timezone);

		$reservationListing = new ReservationListing($timezone);
		$reservationListing->Add(new TestReservationItemView(1,$now->AddHours(-1), $now));
		$this->reservationService->_ReservationListing = $reservationListing;

		$this->presenter->DisplayResource('whatever');

		$this->assertTrue($this->page->_AvailableNow);
	}

	public function testUnvailableNow()
	{
		$now = new Date('2016-03-07 11:00', 'UTC');
		Date::_SetNow($now);
		$scheduleId = 123;
		$timezone = 'America/Chicago';
		$resource = new FakeBookableResource(1);
		$resource->EnableDisplay();
		$this->resourceRepository->_Resource = $resource;
		$schedule = new FakeSchedule($scheduleId);
		$this->scheduleRepository->_Schedule = $schedule;
		$this->scheduleRepository->_Layout = new ScheduleLayout($timezone);

		$reservationListing = new ReservationListing($timezone);
		$reservationListing->Add(new TestReservationItemView(1, $now->AddHours(-1), $now->AddMinutes(1)));
		$this->reservationService->_ReservationListing = $reservationListing;

		$this->presenter->DisplayResource('whatever');

		$this->assertFalse($this->page->_AvailableNow);
	}
	
	public function testWhenNotEnabledToDisplay()
	{
		$resource = new FakeBookableResource(1);
		$this->resourceRepository->_Resource = $resource;
		$this->presenter->DisplayResource('whatever');

		$this->assertTrue($this->page->_DisplayNotEnabledMessage);
	}
}

class TestResourceDisplayPage extends FakePageBase implements IResourceDisplayPage
{
	public $_DisplayLoginCalled = false;
	public $_Username;
	public $_Password;
	public $_BoundInvalidLogin = false;
	public $_BoundResourceList = array();
	public $_ResourceId;
	public $_ActivatedResourceId;
	public $_PublicResourceId;
	public $_DailyLayout;
	public $_BoundResource;
	public $_AvailableNow = false;
	public $_DisplayNotEnabledMessage = false;

	public function TakingAction()
	{
		// TODO: Implement TakingAction() method.
	}

	public function GetAction()
	{
		// TODO: Implement GetAction() method.
	}

	public function RequestingData()
	{
		// TODO: Implement RequestingData() method.
	}

	public function GetDataRequest()
	{
		// TODO: Implement GetDataRequest() method.
	}

	public function GetResourceId()
	{
		// TODO: Implement GetResourceId() method.
	}

	public function DisplayLogin()
	{
		$this->_DisplayLoginCalled = true;
	}

	public function DisplayResourceList()
	{
		// TODO: Implement DisplayResourceList() method.
	}

	public function DisplayResourceAvailability()
	{
		// TODO: Implement DisplayResourceAvailability() method.
	}

	public function GetEmail()
	{
		return $this->_Username;
	}

	public function GetPassword()
	{
		return $this->_Password;
	}

	public function BindInvalidLogin()
	{
		$this->_BoundInvalidLogin = true;
	}

	public function BindResourceList($resourceList)
	{
		$this->_BoundResourceList = $resourceList;
	}

	public function SetActivatedResourceId($publicId)
	{
		$this->_ActivatedResourceId = $publicId;
	}

	public function GetPublicResourceId()
	{
		return $this->_PublicResourceId;
	}

	public function DisplayAvailability(IDailyLayout $dailyLayout, Date $today)
	{
		$this->_DailyLayout = $dailyLayout;
	}

	public function BindResource(BookableResource $resource)
	{
		$this->_BoundResource = $resource;
	}

	public function SetIsAvailableNow($availableNow)
	{
		$this->_AvailableNow = $availableNow;
	}
}