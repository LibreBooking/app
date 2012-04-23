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
 
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/NewReservationInitializer.php');

class ReservationInitializationTests extends TestBase
{
	/**
	 * @var int
	 */
	private $userId;
	
	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;
	
	/**
	 * @var IResourceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceService;

	/**
	 * @var IReservationAuthorization|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationAuthorization;

	public function setup()
	{
		parent::setup();

		$this->userId = $this->fakeUser->UserId;

		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->userRepository = $this->getMock('IUserRepository');
		
		$this->resourceService = $this->getMock('IResourceService');
		$this->reservationAuthorization = $this->getMock('IReservationAuthorization');
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testInitializeSetsDefaultsForSelectedUserAndResourceAndDate()
	{
		$timezone = $this->fakeUser->Timezone;

		$resourceId = 10;
		$scheduleId = 100;
		$dateString = Date::Now()->AddDays(1)->SetTimeString('02:55:22')->Format('Y-m-d H:i:s');
		$endDateString = Date::Now()->AddDays(1)->SetTimeString('4:55:22')->Format('Y-m-d H:i:s');
		$dateInUserTimezone = Date::Parse($dateString, $timezone);

		$firstName = 'fname';
		$lastName = 'lastName';

		$startDate = Date::Parse($dateString, $timezone);
		$endDate = Date::Parse($endDateString, $timezone);
			
		$page = $this->getMock('INewReservationPage');

		$page->expects($this->once())
			->method('GetRequestedResourceId')
			->will($this->returnValue($resourceId));
			
		$page->expects($this->once())
			->method('GetRequestedScheduleId')
			->will($this->returnValue($scheduleId));

		$page->expects($this->any())
			->method('GetReservationDate')
			->will($this->returnValue($dateInUserTimezone));
			
		$page->expects($this->any())
			->method('GetStartDate')
			->will($this->returnValue($startDate));
		
		$page->expects($this->any())
			->method('GetEndDate')
			->will($this->returnValue($endDate));
			
		// DATA
		// users
		$userDto = new UserDto($this->userId, $firstName, $lastName, 'email');

		$this->userRepository->expects($this->once())
			->method('GetById')
			->with($this->userId)
			->will($this->returnValue($userDto));
			
		// resources
		$bookedResource = new ResourceDto($resourceId, 'resource 1');
		$otherResource = new ResourceDto(2, 'resource 2');
		$otherResource2 = new ResourceDto(100, 'something', false);
		$resourceList = array($otherResource, $bookedResource, $otherResource2);
		
		$this->resourceService->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($scheduleId), $this->equalTo(true), $this->equalTo($this->fakeUser))
			->will($this->returnValue($resourceList));

		// accessories
		$accessoryList = array(new AccessoryDto(1, 'a1', 30), new AccessoryDto(2, 'a2', 20));
		$this->resourceService->expects($this->once())
			->method('GetAccessories')
			->will($this->returnValue($accessoryList));
			
		// periods
		$expectedStartPeriod = new SchedulePeriod($dateInUserTimezone->SetTime(new Time(3, 30, 0)), $dateInUserTimezone->SetTime(new Time(4, 30, 0)));
		$expectedEndPeriod = new SchedulePeriod($dateInUserTimezone->SetTime(new Time(4, 30, 0)), $dateInUserTimezone->SetTime(new Time(7, 30, 0)));
		$periods = array(
			new SchedulePeriod($dateInUserTimezone->SetTime(new Time(1, 0, 0)), $dateInUserTimezone->SetTime(new Time(2, 0, 0))),
			new SchedulePeriod($dateInUserTimezone->SetTime(new Time(2, 0, 0)), $dateInUserTimezone->SetTime(new Time(3, 0, 0))),
			new NonSchedulePeriod($dateInUserTimezone->SetTime(new Time(3, 0, 0)), $dateInUserTimezone->SetTime(new Time(3, 30, 0))),
			$expectedStartPeriod,
			$expectedEndPeriod,
			new SchedulePeriod($dateInUserTimezone->SetTime(new Time(7, 30, 0)), $dateInUserTimezone->SetTime(new Time(17, 30, 0))),
			new SchedulePeriod($dateInUserTimezone->SetTime(new Time(17, 30, 0)), $dateInUserTimezone->SetTime(new Time(0, 0, 0))),
		);
		$layout = $this->getMock('IScheduleLayout');

		$this->scheduleRepository->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($scheduleId), $this->equalTo(new ReservationLayoutFactory($timezone)))
			->will($this->returnValue($layout));
			
		$layout->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($dateInUserTimezone))
			->will($this->returnValue($periods));

		// BINDING
		$page->expects($this->once())
			->method('BindPeriods')
			->with($this->equalTo($periods));

		$resourceListWithoutReservationResource = array($otherResource, $otherResource2);
		$page->expects($this->once())
			->method('BindAvailableResources')
			->with($this->equalTo($resourceListWithoutReservationResource));

		$page->expects($this->once())
			->method('ShowAdditionalResources')
			->with($this->equalTo(true));

		$page->expects($this->once())
			->method('BindAvailableAccessories')
			->with($this->equalTo($accessoryList));
			
		// SETUP
		$page->expects($this->once())
			->method('SetSelectedStart')
			->with($this->equalTo($expectedStartPeriod), $this->equalTo($startDate));
		
		$page->expects($this->once())
			->method('SetSelectedEnd')
			->with($this->equalTo($expectedEndPeriod), $this->equalTo($endDate));
		
		$page->expects($this->once())
			->method('SetRepeatTerminationDate')
			->with($this->equalTo($endDate));

		$page->expects($this->once())
			->method('SetReservationUser')
			->with($this->equalTo($userDto));

		$page->expects($this->once())
			->method('SetReservationResource')
			->with($this->equalTo($bookedResource));	// may want this to be a real object

		$canChangeUser = true;
		$this->reservationAuthorization->expects($this->once())
			->method('CanChangeUsers')
			->with($this->equalTo($this->fakeUser))
			->will($this->returnValue($canChangeUser));
		
		$page->expects($this->once())
			->method('SetCanChangeUser')
			->with($this->equalTo($canChangeUser));

        $shouldHideDetails = true;
        $this->fakeConfig->SetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, $shouldHideDetails);

        $page->expects($this->once())
            ->method('ShowUserDetails')
            ->with($this->equalTo(($canChangeUser || !$shouldHideDetails)));
		
		$initializer = new NewReservationInitializer($page, $this->scheduleRepository, $this->userRepository, $this->resourceService, $this->reservationAuthorization, $this->fakeUser);

		$initializer->Initialize();
	}
}
?>