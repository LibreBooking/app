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
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/ExistingReservationInitializer.php');

class ExistingReservationInitializerTests extends TestBase
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
	 * @var IAuthorizationService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $authorizationService;
	
	public function setup()
	{
		parent::setup();

		$this->user = $this->fakeServer->UserSession;
		$this->userId = $this->user->UserId;

		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->userRepository = $this->GetMock('IUserRepository');

		$this->resourceService = $this->getMock('IResourceService');
		$this->authorizationService = $this->getMock('IAuthorizationService');
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testExistingReservationIsLoadedAndBoundToView()
	{
		$this->markTestIncomplete('need to break this apart');
		$referenceNumber = '1234';
		$timezone = $this->user->Timezone;

		$reservationId = 928;
		$resourceId = 10;
		$scheduleId = 100;
		$startDateUtc = '2010-01-01 10:11:12';
		$endDateUtc = '2010-01-02 10:11:12';
		$ownerId = 987;
		$additionalResourceIds = array (10, 20, 30);	
		$participants = array (
			new ReservationUserView(10, 'p1', 'l', null, ReservationUserLevel::PARTICIPANT),
			new ReservationUserView(11, 'p2', 'l', null, ReservationUserLevel::PARTICIPANT)
		);
		$invitees = array (
			new ReservationUserView($this->userId, 'i1', 'l', null, ReservationUserLevel::INVITEE),
			new ReservationUserView(110, 'i2', 'l', null, ReservationUserLevel::INVITEE)
		);
		$accessories = array (
			new ReservationAccessory(1, 2)
		);
		$title = 'title';
		$description = 'description';

		$firstName = 'fname';
		$lastName = 'lastName';
		
		$repeatType = RepeatType::Monthly;
		$repeatInterval = 2;
		$repeatWeekdays = array(1, 2, 3);
		$repeatMonthlyType = 'dayOfMonth';
		$repeatTerminationDate = Date::Parse('2010-01-04', 'UTC');

		$expectedStartDate = Date::Parse($startDateUtc, 'UTC');
		$expectedEndDate = Date::Parse($endDateUtc, 'UTC');	
				
		$reservationView = new ReservationView();
		$reservationView->ReservationId = $reservationId;
		$reservationView->ReferenceNumber = $referenceNumber;
		$reservationView->ResourceId = $resourceId;
		$reservationView->ScheduleId = $scheduleId;
		$reservationView->StartDate = $expectedStartDate;
		$reservationView->EndDate = $expectedEndDate;
		$reservationView->OwnerId = $ownerId;
		$reservationView->OwnerFirstName = $firstName;
		$reservationView->OwnerLastName = $lastName;
		$reservationView->AdditionalResourceIds = $additionalResourceIds;
		$reservationView->Participants = $participants;
		$reservationView->Invitees = $invitees;
		$reservationView->Title = $title;
		$reservationView->Description = $description;
		$reservationView->RepeatType = $repeatType;
		$reservationView->RepeatInterval = $repeatInterval;
		$reservationView->RepeatWeekdays = $repeatWeekdays;
		$reservationView->RepeatMonthlyType = $repeatMonthlyType;
		$reservationView->RepeatTerminationDate = $repeatTerminationDate;
		$reservationView->StatusId = ReservationStatus::Pending;
		$reservationView->Accessories = $accessories;

		$page = $this->getMock('IExistingReservationPage');
		
		// DATA			
		// users
		$reservationUser = new UserDto($ownerId, $firstName, $lastName, 'email');

		$this->userRepository->expects($this->once())
			->method('GetById')
			->with($ownerId)
			->will($this->returnValue($reservationUser));
			
		// resources
		$bookedResource = new ResourceDto($resourceId, 'resource 1');
		$otherResource = new ResourceDto(2, 'resource 2');
		$resourceList = array($otherResource, $bookedResource);

		$this->resourceService->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($scheduleId), $this->equalTo(true), $this->equalTo($this->fakeUser))
			->will($this->returnValue($resourceList));
			
		// periods
		$periods = array(new SchedulePeriod($expectedStartDate->SetTime(new Time(1, 0, 0)), $expectedStartDate->SetTime(new Time(2, 0, 0))));
		$layout = $this->getMock('IScheduleLayout');

		$this->scheduleRepository->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($scheduleId), $this->equalTo(new ReservationLayoutFactory($timezone)))
			->will($this->returnValue($layout));
			
		$layout->expects($this->once())
			->method('GetLayout')
			->with($this->equalTo($expectedStartDate->ToTimezone($timezone)))
			->will($this->returnValue($periods));
		
		// BINDING
		$page->expects($this->once())
			->method('BindPeriods')
			->with($this->equalTo($periods));

		$resourceListWithoutReservationResource = array($otherResource);
		$page->expects($this->once())
			->method('BindAvailableResources')
			->with($this->equalTo($resourceListWithoutReservationResource));
		
		// Reservation Data
		
		$page->expects($this->once())
			->method('SetReservationUser')
			->with($this->equalTo($reservationUser));
			
		$page->expects($this->once())
			->method('SetReservationResource')
			->with($this->equalTo($bookedResource));
		
		$page->expects($this->once())
			->method('SetAdditionalResources')
			->with($this->equalTo($additionalResourceIds));
		
		$page->expects($this->once())
			->method('SetParticipants')
			->with($this->equalTo($participants));

		$page->expects($this->once())
			->method('SetInvitees')
			->with($this->equalTo($invitees));
		
		$page->expects($this->once())
			->method('SetTitle')
			->with($this->equalTo($title));
		
		$page->expects($this->once())
			->method('SetDescription')
			->with($this->equalTo($description));
		
		$page->expects($this->once())
			->method('SetSelectedStart')
			->with($this->equalTo($periods[0]), $this->equalTo($expectedStartDate->ToTimezone($timezone)));

		$page->expects($this->once())
			->method('SetSelectedEnd')
			->with($this->equalTo($periods[0]), $this->equalTo($expectedEndDate->ToTimezone($timezone)));
			
		$page->expects($this->once())
			->method('SetRepeatType')
			->with($this->equalTo($repeatType));
			
		$page->expects($this->once())
			->method('SetRepeatInterval')
			->with($this->equalTo($repeatInterval));
			
		$page->expects($this->once())
			->method('SetRepeatMonthlyType')
			->with($this->equalTo($repeatMonthlyType));
			
		$page->expects($this->any())
			->method('SetRepeatTerminationDate')
			->with($this->anything());
		
		$page->expects($this->once())
			->method('SetRepeatWeekdays')
			->with($this->equalTo($repeatWeekdays));

		$page->expects($this->once())
			->method('SetAccessories')
			->with($this->equalTo($accessories));
		
		$isEditable = true;
		
		$reservationAuthorization = $this->getMock('IReservationAuthorization');
		$reservationAuthorization->expects($this->once())
			->method('CanEdit')
			->with($this->equalTo($reservationView), $this->equalTo($this->user))
			->will($this->returnValue($isEditable));

		$page->expects($this->once())
			->method('SetIsEditable')
			->with($this->equalTo($isEditable));

		$isApprovable = true;
		$reservationAuthorization->expects($this->once())
			->method('CanApprove')
			->with($this->equalTo($reservationView), $this->equalTo($this->user))
			->will($this->returnValue($isApprovable));

		$page->expects($this->once())
			->method('SetIsApprovable')
			->with($this->equalTo($isApprovable));

		$isParticipating = false;
		$page->expects($this->once())
			->method('SetCurrentUserParticipating')
			->with($this->equalTo($isParticipating));

		$isInvited = true;
		$page->expects($this->once())
			->method('SetCurrentUserInvited')
			->with($this->equalTo($isInvited));
		
		$initializer = new ExistingReservationInitializer(
			$page, 
			$this->scheduleRepository,
			$this->userRepository,
			$this->resourceService,
			$reservationView,
			$reservationAuthorization,
			$this->fakeUser);
			
		$initializer->Initialize();
	}
}
?>