<?php
/**
 * Copyright 2017 Nick Korbel
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
     * @var FakeGuestUserService
     */
    private $guestUserService;

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

    /**
     * @var FakeReservationHandler
     */
    private $reservationHandler;

    /**
     * @var FakeAttributeService
     */
    private $attributeService;

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
        $this->guestUserService = new FakeGuestUserService();
        $this->reservationHandler = new FakeReservationHandler();
        $this->attributeService = new FakeAttributeService();
        $this->presenter = new ResourceDisplayPresenter($this->page,
            $this->resourceRepository,
            $this->reservationService,
            $this->authorizationService,
            $this->authentication,
            $this->scheduleRepository,
            $this->dailyLayoutFactory,
            $this->guestUserService,
            $this->attributeService);
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
        $this->attributeService->_ReservationAttributes = array();

        $this->presenter->reservationHandler = $this->reservationHandler;
        $this->presenter->DisplayResource($publicId);
        $expectedDate = DateRange::Create('2016-03-07', '2016-03-08', 'UTC');

        $this->assertEquals(new DailyLayout($this->reservationService->_ReservationListing,
            $this->scheduleRepository->_Layout), $this->page->_DailyLayout);
        $this->assertEquals($expectedDate, $this->reservationService->_LastDateRange);
        $this->assertEquals(1, $this->reservationService->_LastResourceId);
        $this->assertEquals($resource, $this->page->_BoundResource);
        $this->assertFalse($this->page->_DisplayNotEnabledMessage);
        $this->assertEquals($this->attributeService->_ReservationAttributes, $this->page->_Attributes);
    }

    public function testWhenNotEnabledToDisplay()
    {
        $resource = new FakeBookableResource(1);
        $this->resourceRepository->_Resource = $resource;

        $this->presenter->DisplayResource('whatever');

        $this->assertTrue($this->page->_DisplayNotEnabledMessage);
    }

    public function testWhenBookingSucceeds()
    {
        Date::_SetNow(Date::Parse('2016-03-11 13:46'));
        $this->page->_Email = 'some@user.com';
        $this->page->_BeginTime = '08:00';
        $this->page->_EndTime = '17:00';
        $this->page->_Timezone = 'America/New_York';
        $this->page->_ResourceId = 292;

        $userAccount = new FakeUserSession(123);
        $this->guestUserService->_UserSession = $userAccount;
        $this->reservationHandler->_Success = true;

        $resource = new FakeBookableResource(122);
        $this->resourceRepository->_Resource = $resource;

        $begin = Date::Parse('2016-03-11 08:00', $this->page->_Timezone);
        $end = Date::Parse('2016-03-11 17:00', $this->page->_Timezone);

        $this->presenter->reservationHandler = $this->reservationHandler;

        $this->presenter->Reserve();

        $this->assertEquals(true, $this->page->_ReservationCreatedSuccessfully);
        $this->assertEquals($resource, $this->reservationHandler->_LastSeries->Resource());
        $this->assertEquals($userAccount->UserId, $this->reservationHandler->_LastSeries->UserId());
        $this->assertEquals($userAccount, $this->reservationHandler->_LastSeries->BookedBy());
        $this->assertEquals($begin, $this->reservationHandler->_LastSeries->CurrentInstance()->StartDate());
        $this->assertEquals($end, $this->reservationHandler->_LastSeries->CurrentInstance()->EndDate());
    }

    public function testWhenReservationFails()
    {
        Date::_SetNow(Date::Parse('2016-03-11 13:46'));
        $this->page->_Email = 'some@user.com';
        $this->page->_BeginTime = '08:00';
        $this->page->_EndTime = '17:00';
        $this->page->_Timezone = 'America/New_York';
        $this->page->_ResourceId = 292;

        $userAccount = new FakeUserSession(123);
        $this->guestUserService->_UserSession = $userAccount;
        $this->reservationHandler->_Success = false;
        $this->reservationHandler->_Errors = array('one', 'two');

        $resource = new FakeBookableResource(122);
        $this->resourceRepository->_Resource = $resource;

        $this->presenter->reservationHandler = $this->reservationHandler;

        $this->presenter->Reserve();

        $this->assertEquals(false, $this->page->_ReservationCreatedSuccessfully);
        $this->assertEquals($this->reservationHandler->_Errors, $this->page->_ResultCollector->Errors);
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
    public $_Email;
    public $_BeginTime;
    public $_EndTime;
    public $_Timezone;
    public $_ReservationCreatedSuccessfully;
    /**
     * @var ReservationResultCollector
     */
    public $_ResultCollector;

    public $_Attributes;

    public $_AttributeFormElements = array();

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

    public function DisplayNotEnabled()
    {
        $this->_DisplayNotEnabledMessage = true;
    }

    public function DisplayResourceShell()
    {
        // TODO: Implement DisplayResourceShell() method.
    }

    public function GetTimezone()
    {
        return $this->_Timezone;
    }

    public function GetBeginTime()
    {
        return $this->_BeginTime;
    }

    public function GetEndTime()
    {
        return $this->_EndTime;
    }

    public function SetReservationSaveResults($success, $resultCollector)
    {
        $this->_ReservationCreatedSuccessfully = $success;
        $this->_ResultCollector = $resultCollector;
    }

    public function BindSchedule(Schedule $schedule)
    {
        // TODO: Implement BindSchedule() method.
    }

    public function BindAttributes($attributes)
    {
        $this->_Attributes = $attributes;
    }

    public function GetAttributes()
    {
       return $this->_AttributeFormElements;
    }
}