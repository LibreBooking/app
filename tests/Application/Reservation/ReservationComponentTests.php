<?php
/**
 * Copyright 2012-2014 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');


require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');

class ReservationComponentTests extends TestBase
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
	 * @var IAttributeRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeRepository;

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

	/**
	 * @var IReservationComponentInitializer|PHPUnit_Framework_MockObject_MockObject
	 */
	private $initializer;

	public function setup()
	{
		parent::setup();

		$this->userId = 9999;

		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->attributeRepository = $this->getMock('IAttributeRepository');
		$this->userRepository = $this->getMock('IUserRepository');

		$this->resourceService = $this->getMock('IResourceService');
		$this->reservationAuthorization = $this->getMock('IReservationAuthorization');

		$this->initializer = $this->getMock('IReservationComponentInitializer');
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testBindsUserData()
	{
		$userDto = new UserDto($this->userId, 'f', 'l', 'email');

		$current = new FakeUser();
		$current->_IsAdminForUser = true;

		$owner = new FakeUser();

		$this->userRepository->expects($this->at(1))
							 ->method('LoadById')
							 ->with($this->equalTo($this->fakeUser->UserId))
							 ->will($this->returnValue($current));

		$this->userRepository->expects($this->at(2))
							 ->method('LoadById')
							 ->with($this->equalTo($this->userId))
							 ->will($this->returnValue($owner));

		$this->initializer->expects($this->once())
						  ->method('GetOwnerId')
						  ->will($this->returnValue($this->userId));

		$this->initializer->expects($this->atLeastOnce())
						  ->method('CurrentUser')
						  ->will($this->returnValue($this->fakeUser));

		$this->userRepository->expects($this->once())
							 ->method('GetById')
							 ->with($this->equalTo($this->userId))
							 ->will($this->returnValue($userDto));

		$this->reservationAuthorization->expects($this->once())
									   ->method('CanChangeUsers')
									   ->with($this->fakeUser)
									   ->will($this->returnValue(true));

		$this->fakeConfig->SetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, 'true');
		$this->initializer->expects($this->once())
			->method('SetShowParticipation')
			->with($this->equalTo(false));

		$this->initializer->expects($this->once())
						  ->method('SetCanChangeUser')
						  ->with($this->equalTo(true));

		$this->initializer->expects($this->once())
						  ->method('SetReservationUser')
						  ->with($this->equalTo($userDto));

		$this->initializer->expects($this->once())
						  ->method('SetIsAdminForUser')
						  ->with($this->equalTo(true));

		$binder = new ReservationUserBinder($this->userRepository, $this->reservationAuthorization);
		$binder->Bind($this->initializer);
	}

	public function testBindsResourceData()
	{
		$requestedScheduleId = 10;
		$requestedResourceId = 90;

		$user = new FakeUser();
		$user->_IsResourceAdmin = true;

		$this->userRepository->expects($this->once())
							 ->method('LoadById')
							 ->with($this->equalTo($this->fakeUser->UserId))
							 ->will($this->returnValue($user));

		$this->initializer->expects($this->atLeastOnce())
						  ->method('GetScheduleId')
						  ->will($this->returnValue($requestedScheduleId));

		$this->initializer->expects($this->atLeastOnce())
						  ->method('GetResourceId')
						  ->will($this->returnValue($requestedResourceId));

		$this->initializer->expects($this->atLeastOnce())
						  ->method('CurrentUser')
						  ->will($this->returnValue($this->fakeUser));


		$bookedResource = new ResourceGroupAssignment(null, new FakeBookableResource($requestedResourceId, 'resource 1'));
		$otherResource = new ResourceGroupAssignment(null, new FakeBookableResource(2, 'resource 2'));
		$otherResource2 = new ResourceGroupAssignment(null, new FakeBookableResource(100, 'something'));
		$resourceList = array($otherResource, $bookedResource, $otherResource2);

		$groups = new FakeResourceGroupTree();
		$groups->WithAllResources($resourceList);

		$this->resourceService->expects($this->once())
							  ->method('GetResourceGroups')
							  ->with($this->equalTo($requestedScheduleId), $this->equalTo($this->fakeUser))
		->will($this->returnValue($groups));

		// accessories
		$accessoryList = array(new Accessory(1, 'a1', 30), new Accessory(2, 'a2', 20));
		$this->resourceService->expects($this->once())
		->method('GetAccessories')
		->will($this->returnValue($accessoryList));

		$this->initializer->expects($this->once())
						  ->method('BindResourceGroups')
						  ->with($this->equalTo($groups));

		$this->initializer->expects($this->once())
						  ->method('ShowAdditionalResources')
						  ->with($this->equalTo(true));

		$this->initializer->expects($this->once())
						  ->method('BindAvailableAccessories')
						  ->with($this->equalTo($accessoryList));

		$this->initializer->expects($this->once())
						  ->method('SetReservationResource')
						  ->with($this->equalTo($bookedResource->GetResource()));

		$this->initializer->expects($this->once())
					->method('SetIsAdminForResource')
					->with($this->equalTo(true));

		$binder = new ReservationResourceBinder($this->resourceService, $this->userRepository);
		$binder->Bind($this->initializer);
	}

	public function testRedirectsIfUserHasPermissionToZeroResources()
	{
		$requestedScheduleId = 10;
		$requestedResourceId = null;

		$this->initializer->expects($this->once())
						  ->method('GetScheduleId')
						  ->will($this->returnValue($requestedScheduleId));

		$this->initializer->expects($this->once())
						  ->method('GetResourceId')
						  ->will($this->returnValue($requestedResourceId));

		$this->initializer->expects($this->once())
						  ->method('CurrentUser')
						  ->will($this->returnValue($this->fakeUser));

		$resourceList = array();
		$groups = new FakeResourceGroupTree();
		$groups->WithAllResources($resourceList);

		$this->resourceService->expects($this->once())
							  ->method('GetResourceGroups')
							  ->with($this->equalTo($requestedScheduleId), $this->equalTo($this->fakeUser))
							  ->will($this->returnValue($groups));

		$this->initializer->expects($this->once())
						  ->method('RedirectToError')
						  ->with($this->equalTo(ErrorMessages::INSUFFICIENT_PERMISSIONS));

		$binder = new ReservationResourceBinder($this->resourceService, $this->userRepository);
		$binder->Bind($this->initializer);
	}

	public function testBindsDates()
	{
		$timezone = 'UTC';
		$scheduleId = 1;
		$dateString = Date::Now()->AddDays(1)->SetTimeString('02:55:22')->Format('Y-m-d H:i:s');
		$endDateString = Date::Now()->AddDays(1)->SetTimeString('4:55:22')->Format('Y-m-d H:i:s');
		$dateInUserTimezone = Date::Parse($dateString, $timezone);

		$startDate = Date::Parse($dateString, $timezone);
		$endDate = Date::Parse($endDateString, $timezone);

		$resource = new ResourceGroupAssignment(1, new FakeBookableResource(123, 'rn'));

		$this->initializer->expects($this->any())
						  ->method('CurrentUser')
						  ->will($this->returnValue($this->fakeUser));

		$this->initializer->expects($this->any())
						  ->method('GetTimezone')
						  ->will($this->returnValue($timezone));

		$this->initializer->expects($this->any())
						  ->method('GetReservationDate')
						  ->will($this->returnValue($dateInUserTimezone));

		$this->initializer->expects($this->any())
						  ->method('GetStartDate')
						  ->will($this->returnValue($startDate));

		$this->initializer->expects($this->any())
						  ->method('GetEndDate')
						  ->will($this->returnValue($endDate));

		$this->initializer->expects($this->any())
						  ->method('GetScheduleId')
						  ->will($this->returnValue($scheduleId));

		$this->initializer->expects($this->any())
						  ->method('PrimaryResource')
						  ->will($this->returnValue($resource));

		$startPeriods = array(new SchedulePeriod(Date::Now(), Date::Now()));
		$endPeriods = array(new SchedulePeriod(Date::Now()->AddDays(1), Date::Now()->AddDays(1)));
		$layout = $this->getMock('IScheduleLayout');

		$this->scheduleRepository->expects($this->once())
								 ->method('GetLayout')
								 ->with($this->equalTo($scheduleId),
										$this->equalTo(new ReservationLayoutFactory($timezone)))
								 ->will($this->returnValue($layout));

		$layout->expects($this->at(0))
			   ->method('GetLayout')
			   ->with($this->equalTo($startDate))
			   ->will($this->returnValue($startPeriods));

		$layout->expects($this->at(1))
			   ->method('GetLayout')
			   ->with($this->equalTo($endDate))
			   ->will($this->returnValue($endPeriods));

		$this->initializer->expects($this->once())
						  ->method('SetDates')
						  ->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($startPeriods),
								 $this->equalTo($endPeriods));

		$this->initializer->expects($this->once())
						  ->method('HideRecurrence')
						  ->with($this->equalTo(false));

		$binder = new ReservationDateBinder($this->scheduleRepository);
		$binder->Bind($this->initializer);
	}

	public function testBindsDatesWhenResourceHasMinimumTime()
	{
		$timezone = 'UTC';
		$scheduleId = 1;
		$dateString = Date::Now()->AddDays(1)->SetTimeString('02:55:22')->Format('Y-m-d H:i:s');
		$endDateString = Date::Now()->AddDays(1)->SetTimeString('4:55:22')->Format('Y-m-d H:i:s');
		$dateInUserTimezone = Date::Parse($dateString, $timezone);

		$startDate = Date::Parse($dateString, $timezone);
		$endDate = Date::Parse($endDateString, $timezone);

		$expectedEndDate = $startDate->AddHours(2);

		$resource = new FakeBookableResource(1, 'resource');
		$resource->SetMinLength(TimeInterval::FromHours(2));
		$resource->SetScheduleId($scheduleId);

		$this->initializer->expects($this->any())
						  ->method('CurrentUser')
						  ->will($this->returnValue($this->fakeUser));

		$this->initializer->expects($this->any())
						  ->method('GetTimezone')
						  ->will($this->returnValue($timezone));

		$this->initializer->expects($this->any())
						  ->method('GetReservationDate')
						  ->will($this->returnValue($dateInUserTimezone));

		$this->initializer->expects($this->any())
						  ->method('GetStartDate')
						  ->will($this->returnValue($startDate));

		$this->initializer->expects($this->any())
						  ->method('GetEndDate')
						  ->will($this->returnValue($endDate));

		$this->initializer->expects($this->any())
						  ->method('GetScheduleId')
						  ->will($this->returnValue($scheduleId));

		$this->initializer->expects($this->any())
						  ->method('PrimaryResource')
						  ->will($this->returnValue($resource));

		$startPeriods = array(new SchedulePeriod(Date::Now(), Date::Now()));
		$endPeriods = array(new SchedulePeriod(Date::Now()->AddDays(1), Date::Now()->AddDays(1)));
		$layout = $this->getMock('IScheduleLayout');

		$this->scheduleRepository->expects($this->once())
								 ->method('GetLayout')
								 ->with($this->equalTo($scheduleId),
										$this->equalTo(new ReservationLayoutFactory($timezone)))
								 ->will($this->returnValue($layout));

		$layout->expects($this->at(0))
			   ->method('GetLayout')
			   ->with($this->equalTo($startDate))
			   ->will($this->returnValue($startPeriods));

		$layout->expects($this->at(1))
			   ->method('GetLayout')
			   ->with($this->equalTo($endDate))
			   ->will($this->returnValue($endPeriods));

		$this->initializer->expects($this->once())
						  ->method('SetDates')
						  ->with($this->equalTo($startDate), $this->equalTo($expectedEndDate),
								 $this->equalTo($startPeriods),
								 $this->equalTo($endPeriods));

		$this->initializer->expects($this->once())
						  ->method('HideRecurrence')
						  ->with($this->equalTo(false));

		$this->initializer->expects($this->once())
						  ->method('IsNew')
						  ->will($this->returnValue(true));

		$binder = new ReservationDateBinder($this->scheduleRepository);
		$binder->Bind($this->initializer);
	}

	public function testMovesFirstPeriodToEndIfTimeIsLaterInTheDay()
	{
		$timezone = 'UTC';
		$scheduleId = 1;
		$dateString = Date::Now()->AddDays(1)->SetTimeString('02:55:22')->Format('Y-m-d H:i:s');
		$dateInUserTimezone = Date::Parse($dateString, $timezone);

		$requestedDate = Date::Parse($dateString, $timezone);

		$this->initializer->expects($this->any())
						  ->method('CurrentUser')
						  ->will($this->returnValue($this->fakeUser));

		$this->initializer->expects($this->any())
						  ->method('GetTimezone')
						  ->will($this->returnValue($timezone));

		$this->initializer->expects($this->any())
						  ->method('GetReservationDate')
						  ->will($this->returnValue($dateInUserTimezone));

		$this->initializer->expects($this->any())
						  ->method('GetStartDate')
						  ->will($this->returnValue($requestedDate));

		$this->initializer->expects($this->any())
						  ->method('GetEndDate')
						  ->will($this->returnValue($requestedDate));

		$this->initializer->expects($this->any())
						  ->method('GetScheduleId')
						  ->will($this->returnValue($scheduleId));

		$periods = array(
				new SchedulePeriod(Date::Parse('2012-01-22 22:00', $timezone), Date::Parse('2012-01-22 10:00',
																						   $timezone)),
				new SchedulePeriod(Date::Parse('2012-01-22 10:00', $timezone), Date::Parse('2012-01-23 22:00',
																						   $timezone)),
		);
		$startPeriods = array($periods[1], $periods[0]);
		$layout = $this->getMock('IScheduleLayout');

		$this->scheduleRepository->expects($this->once())
								 ->method('GetLayout')
								 ->with($this->equalTo($scheduleId),
										$this->equalTo(new ReservationLayoutFactory($timezone)))
								 ->will($this->returnValue($layout));

		$layout->expects($this->any())
			   ->method('GetLayout')
			   ->with($this->equalTo($requestedDate))
			   ->will($this->returnValue($periods));

		$this->initializer->expects($this->once())
						  ->method('SetDates')
						  ->with($this->equalTo($requestedDate), $this->equalTo($requestedDate),
								 $this->equalTo($startPeriods),
								 $this->equalTo($periods));

		$binder = new ReservationDateBinder($this->scheduleRepository);
		$binder->Bind($this->initializer);
	}

	public function testBindsReservationDetails()
	{
		$page = $this->getMock('IExistingReservationPage');
		$reservationAuthorization = $this->getMock('IReservationAuthorization');
		$privacyFilter = $this->getMock('IPrivacyFilter');
		$initializer = $this->getMock('IReservationComponentInitializer');

		$timezone = 'UTC';
		$repeatType = RepeatType::Monthly;
		$repeatInterval = 2;
		$repeatWeekdays = array(1, 2, 3);
		$repeatMonthlyType = 'dayOfMonth';
		$repeatTerminationDate = Date::Parse('2010-01-04', 'UTC');

		$title = 'title';
		$description = 'description';

		$firstName = 'fname';
		$lastName = 'lastName';

		$reservationId = 928;
		$resourceId = 10;
		$scheduleId = 100;
		$referenceNumber = '1234';

		$startDateUtc = '2010-01-01 10:11:12';
		$endDateUtc = '2010-01-02 10:11:12';
		$ownerId = 987;
		$additionalResourceIds = array(10, 20, 30);
		$participants = array(
				new ReservationUserView(10, 'p1', 'l', null, ReservationUserLevel::PARTICIPANT),
				new ReservationUserView(11, 'p2', 'l', null, ReservationUserLevel::PARTICIPANT)
		);
		$invitees = array(
				new ReservationUserView($this->fakeUser->UserId, 'i1', 'l', null, ReservationUserLevel::INVITEE),
				new ReservationUserView(110, 'i2', 'l', null, ReservationUserLevel::INVITEE)
		);
		$accessories = array(
				new ReservationAccessory(1, 2)
		);

		$attachments = array(
				new ReservationAttachmentView(1, 2, 'filename')
		);

		$expectedStartDate = Date::Parse($startDateUtc, 'UTC');
		$expectedEndDate = Date::Parse($endDateUtc, 'UTC');

		$startReminderValue = 15;
		$startReminderInterval = ReservationReminderInterval::Minutes;

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
		$reservationView->Attachments = $attachments;
		$reservationView->StartReminder = new ReservationReminderView($startReminderValue);
		$reservationView->EndReminder = null;

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
			 ->with($repeatTerminationDate->ToTimezone($timezone));

		$page->expects($this->once())
			 ->method('SetRepeatWeekdays')
			 ->with($this->equalTo($repeatWeekdays));

		$page->expects($this->once())
			 ->method('SetAccessories')
			 ->with($this->equalTo($accessories));

		$page->expects($this->once())
			 ->method('SetAttachments')
			 ->with($this->equalTo($attachments));

		$isEditable = false;

		$reservationAuthorization->expects($this->once())
								 ->method('CanEdit')
								 ->with($this->equalTo($reservationView), $this->equalTo($this->fakeUser))
								 ->will($this->returnValue($isEditable));

		$page->expects($this->once())
			 ->method('SetIsEditable')
			 ->with($this->equalTo($isEditable));

		$isApprovable = true;
		$reservationAuthorization->expects($this->once())
								 ->method('CanApprove')
								 ->with($this->equalTo($reservationView), $this->equalTo($this->fakeUser))
								 ->will($this->returnValue($isApprovable));

		$page->expects($this->once())
			 ->method('SetIsApprovable')
			 ->with($this->equalTo($isApprovable));

		$isParticipating = false;
		$page->expects($this->once())
			 ->method('SetCurrentUserParticipating')
			 ->with($this->equalTo($isParticipating));

		$page->expects($this->once())
			 ->method('SetStartReminder')
			 ->with($this->equalTo($startReminderValue), $this->equalTo($startReminderInterval));

		$page->expects($this->never())
			 ->method('SetEndReminder');

		$isInvited = true;
		$page->expects($this->once())
			 ->method('SetCurrentUserInvited')
			 ->with($this->equalTo($isInvited));

		$initializer->expects($this->atLeastOnce())
					->method('GetTimezone')
					->will($this->returnValue($timezone));

		$initializer->expects($this->atLeastOnce())
					->method('CurrentUser')
					->will($this->returnValue($this->fakeUser));

		$canViewDetails = true;
		$canViewUser = true;
		$privacyFilter->expects($this->once())
					  ->method('CanViewDetails')
					  ->with($this->equalTo($this->fakeUser), $this->equalTo($reservationView))
					  ->will($this->returnValue($canViewDetails));

		$privacyFilter->expects($this->once())
					  ->method('CanViewUser')
					  ->with($this->equalTo($this->fakeUser), $this->equalTo($reservationView))
					  ->will($this->returnValue($canViewUser));

		$initializer->expects($this->once())
					->method('ShowUserDetails')
					->with($this->equalTo($canViewDetails));

		$initializer->expects($this->once())
					->method('ShowReservationDetails')
					->with($this->equalTo($canViewDetails));

		$binder = new ReservationDetailsBinder($reservationAuthorization, $page, $reservationView, $privacyFilter);
		$binder->Bind($initializer);
	}
}