<?php
/**
 * Copyright 2011-2014 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

class ManageReservationsPresenterTests extends TestBase
{
	/**
	 * @var ManageReservationsPresenter
	 */
	private $presenter;

	/**
	 * @var IManageReservationsPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IManageReservationsService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationsService;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	/**
	 * @var IUserPreferenceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userPreferenceRepository;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageReservationsPage');
		$this->reservationsService = $this->getMock('IManageReservationsService');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->attributeService = $this->getMock('IAttributeService');
		$this->userPreferenceRepository = $this->getMock('IUserPreferenceRepository');

		$this->presenter = new ManageReservationsPresenter($this->page,
														   $this->reservationsService,
														   $this->scheduleRepository,
														   $this->resourceRepository,
														   $this->attributeService,
														   $this->userPreferenceRepository);

		$this->userPreferenceRepository->expects($this->any())
									   ->method('GetAllUserPreferences')
									   ->with($this->anything())
									   ->will($this->returnValue(array()));
	}

	public function testUsesTwoWeekSpanWhenNoDateFilterProvided()
	{
		$userTimezone = 'America/Chicago';
		$defaultStart = Date::Now()->AddDays(-7)->ToTimezone($userTimezone)->GetDate();
		$defaultEnd = Date::Now()->AddDays(7)->ToTimezone($userTimezone)->GetDate();
		$searchedScheduleId = 15;
		$searchedResourceId = 105;
		$searchedStatusId = ReservationStatus::Pending;
		$searchedUserId = 111;
		$searchedReferenceNumber = 'abc123';
		$searchedUserName = 'some user';
		$searchedResourceStatusId = 292;
		$searchedResourceStatusReasonId = 4292;

		$this->resourceRepository->expects($this->once())
								 ->method('GetStatusReasons')
								 ->will($this->returnValue(array()));

		$this->page->expects($this->any())
				   ->method('FilterButtonPressed')
				   ->will($this->returnValue(true));

		$this->page->expects($this->atLeastOnce())
				   ->method('GetStartDate')
				   ->will($this->returnValue(null));

		$this->page->expects($this->atLeastOnce())
				   ->method('GetEndDate')
				   ->will($this->returnValue(null));

		$this->page->expects($this->once())
				   ->method('GetScheduleId')
				   ->will($this->returnValue($searchedScheduleId));

		$this->page->expects($this->once())
				   ->method('GetResourceId')
				   ->will($this->returnValue($searchedResourceId));

		$this->page->expects($this->once())
				   ->method('GetReservationStatusId')
				   ->will($this->returnValue($searchedStatusId));

		$this->page->expects($this->once())
				   ->method('GetUserId')
				   ->will($this->returnValue($searchedUserId));

		$this->page->expects($this->once())
				   ->method('GetUserName')
				   ->will($this->returnValue($searchedUserName));

		$this->page->expects($this->once())
				   ->method('GetReferenceNumber')
				   ->will($this->returnValue($searchedReferenceNumber));

		$this->page->expects($this->once())
				   ->method('GetResourceStatusFilterId')
				   ->will($this->returnValue($searchedResourceStatusId));

		$this->page->expects($this->once())
				   ->method('GetResourceStatusReasonFilterId')
				   ->will($this->returnValue($searchedResourceStatusReasonId));

		$filter = $this->GetExpectedFilter($defaultStart, $defaultEnd, $searchedReferenceNumber, $searchedScheduleId,
										   $searchedResourceId, $searchedUserId, $searchedStatusId, $searchedResourceStatusId, $searchedResourceStatusReasonId);

		$data = new PageableData($this->getReservations());
		$this->reservationsService->expects($this->once())
								  ->method('LoadFiltered')
								  ->with($this->anything(), $this->anything(), $this->equalTo($filter),
										 $this->equalTo($this->fakeUser))
								  ->will($this->returnValue($data));

		$attributeList = new AttributeList();
		$this->attributeService->expects($this->once())
							   ->method('GetAttributes')
							   ->with($this->equalTo(CustomAttributeCategory::RESERVATION),
									  $this->equalTo(range(1, 10)))
							   ->will($this->returnValue($attributeList));

		$this->page->expects($this->once())
				   ->method('SetStartDate')
				   ->with($this->equalTo($defaultStart));

		$this->page->expects($this->once())
				   ->method('SetEndDate')
				   ->with($this->equalTo($defaultEnd));

		$this->page->expects($this->once())
				   ->method('SetReferenceNumber')
				   ->with($this->equalTo($searchedReferenceNumber));

		$this->page->expects($this->once())
				   ->method('SetScheduleId')
				   ->with($this->equalTo($searchedScheduleId));

		$this->page->expects($this->once())
				   ->method('SetResourceId')
				   ->with($this->equalTo($searchedResourceId));

		$this->page->expects($this->once())
				   ->method('SetReservationStatusId')
				   ->with($this->equalTo($searchedStatusId));

		$this->page->expects($this->once())
				   ->method('SetUserId')
				   ->with($this->equalTo($searchedUserId));

		$this->page->expects($this->once())
				   ->method('SetUserName')
				   ->with($this->equalTo($searchedUserName));

		$this->page->expects($this->once())
				   ->method('SetUserName')
				   ->with($this->equalTo($searchedUserName));

		$this->page->expects($this->once())
				   ->method('SetResourceStatusFilterId')
				   ->with($this->equalTo($searchedResourceStatusId));

		$this->page->expects($this->once())
				   ->method('SetResourceStatusReasonFilterId')
				   ->with($this->equalTo($searchedResourceStatusReasonId));

		$this->presenter->PageLoad($userTimezone);
	}

	public function testUpdatesSingleResourceStatus()
	{
		$resourceId = 19191;
		$resourceStatusId = ResourceStatus::HIDDEN;
		$resourceStatusReasonId = 111;
		$referenceNumber = 'abc123';

		$resource = new FakeBookableResource($resourceId);
		$resource->ChangeStatus(ResourceStatus::AVAILABLE, null);

		$this->page->expects($this->once())
					->method('CanUpdateResourceStatuses')
					->will($this->returnValue(true));

		$this->page->expects($this->once())
				   ->method('GetResourceStatus')
				   ->will($this->returnValue($resourceStatusId));

		$this->page->expects($this->once())
						   ->method('GetUpdateScope')
						   ->will($this->returnValue(''));

		$this->page->expects($this->once())
				   ->method('GetResourceStatusReason')
				   ->will($this->returnValue($resourceStatusReasonId));

		$this->page->expects($this->once())
				   ->method('GetUpdateResourceId')
				   ->will($this->returnValue($resourceId));

		$this->page->expects($this->once())
				   ->method('GetResourceStatusReferenceNumber')
				   ->will($this->returnValue($referenceNumber));

		$this->resourceRepository->expects($this->once())
								 ->method('LoadById')
								 ->with($resourceId)
								 ->will($this->returnValue($resource));

		$this->resourceRepository->expects($this->once())
								 ->method('Update')
								 ->with($this->anything());

		$this->presenter->UpdateResourceStatus();

		$this->assertEquals($resourceStatusId, $resource->GetStatusId());
		$this->assertEquals($resourceStatusReasonId, $resource->GetStatusReasonId());
	}

	public function testUpdatesReservationResourceStatuses()
	{
		$resourceStatusId = ResourceStatus::HIDDEN;
		$resourceStatusReasonId = 111;
		$referenceNumber = 'abc123';

		$reservations = array(new TestReservationItemView(1, Date::Now(), Date::Now(), 1),new TestReservationItemView(1, Date::Now(), Date::Now(), 2));
		$pageableReservations = new PageableData($reservations);

		$resource1 = new FakeBookableResource(1);
		$resource1->ChangeStatus(ResourceStatus::AVAILABLE, null);

		$resource2 = new FakeBookableResource(2);
		$resource2->ChangeStatus(ResourceStatus::AVAILABLE, null);

		$this->page->expects($this->once())
				   ->method('GetResourceStatus')
				   ->will($this->returnValue($resourceStatusId));

		$this->page->expects($this->once())
				   ->method('GetUpdateScope')
				   ->will($this->returnValue('all'));

		$this->page->expects($this->once())
				   ->method('GetResourceStatusReason')
				   ->will($this->returnValue($resourceStatusReasonId));

		$this->page->expects($this->once())
				   ->method('GetResourceStatusReferenceNumber')
				   ->will($this->returnValue($referenceNumber));

		$this->reservationsService->expects($this->once())
								 ->method('LoadFiltered')
								 ->with($this->isNull(), $this->isNull(), $this->equalTo(new ReservationFilter(null, null, $referenceNumber, null, null, null, null, null)), $this->equalTo($this->fakeUser))
								 ->will($this->returnValue($pageableReservations));

		$this->resourceRepository->expects($this->at(0))
								 ->method('LoadById')
								 ->with(1)
								 ->will($this->returnValue($resource1));

		$this->resourceRepository->expects($this->at(2))
								 ->method('LoadById')
								 ->with(2)
								 ->will($this->returnValue($resource2));

		$this->resourceRepository->expects($this->at(1))
								 ->method('Update')
								 ->with($this->anything());

		$this->resourceRepository->expects($this->at(3))
								 ->method('Update')
								 ->with($this->anything());

		$this->presenter->UpdateResourceStatus();

		$this->assertEquals($resourceStatusId, $resource1->GetStatusId());
		$this->assertEquals($resourceStatusReasonId, $resource1->GetStatusReasonId());
	}

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @param int $statusId
	 * @param null $resourceStatusId
	 * @param null $resourceStatusReasonId
	 * @return ReservationFilter
	 */
	private function GetExpectedFilter($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null,
									   $resourceId = null, $userId = null, $statusId = null, $resourceStatusId = null,
									   $resourceStatusReasonId = null)
	{
		return new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId, $statusId, $resourceStatusId, $resourceStatusReasonId);
	}

	private function getReservations()
	{
		$reservations = array();
		for ($i = 1; $i <= 10; $i++)
		{
			$r1 = new ReservationItemView();
			$r1->SeriesId = $i;
			$reservations[] = $r1;
		}

		return $reservations;

	}
}