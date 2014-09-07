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

require_once(ROOT_DIR . 'WebServices/ResourcesWebService.php');

class ResourcesWebServiceTests extends TestBase
{
	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repository;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationRepository;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	/**
	 * @var ResourcesWebService
	 */
	private $service;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->repository = $this->getMock('IResourceRepository');
		$this->reservationRepository = $this->getMock('IReservationViewRepository');
		$this->attributeService = $this->getMock('IAttributeService');

		$this->service = new ResourcesWebService($this->server, $this->repository, $this->attributeService, $this->reservationRepository);
	}

	public function testGetsResourceById()
	{
		$resourceId = 8282;
		$resource = new FakeBookableResource($resourceId);
		$resource->SetBufferTime(3600);

		$attributes = new AttributeList();

		$this->repository->expects($this->once())
						 ->method('LoadById')
						 ->with($this->equalTo($resourceId))
						 ->will($this->returnValue($resource));

		$this->attributeService->expects($this->once())
							   ->method('GetAttributes')
							   ->with($this->equalTo(CustomAttributeCategory::RESOURCE),
									  $this->equalTo(array($resourceId)))
							   ->will($this->returnValue($attributes));

		$this->service->GetResource($resourceId);

		$this->assertEquals(new ResourceResponse($this->server, $resource, $attributes), $this->server->_LastResponse);
	}

	public function testWhenNotFound()
	{
		$resourceId = 8282;
		$this->repository->expects($this->once())
						 ->method('LoadById')
						 ->with($this->equalTo($resourceId))
						 ->will($this->returnValue(BookableResource::Null()));

		$this->service->GetResource($resourceId);

		$this->assertEquals(RestResponse::NotFound(), $this->server->_LastResponse);
	}

	public function testGetsResourceList()
	{
		$resourceId = 123;
		$resources[] = new FakeBookableResource($resourceId);
		$attributes = new AttributeList();

		$this->repository->expects($this->once())
						 ->method('GetResourceList')
						 ->will($this->returnValue($resources));

		$this->attributeService->expects($this->once())
							   ->method('GetAttributes')
							   ->with($this->equalTo(CustomAttributeCategory::RESOURCE),
									  $this->equalTo(array($resourceId)))
							   ->will($this->returnValue($attributes));

		$this->service->GetAll();

		$this->assertEquals(new ResourcesResponse($this->server, $resources, $attributes),
							$this->server->_LastResponse);
	}

	public function testGetsStatuses()
	{
		$this->service->GetStatuses();

		$this->assertEquals(new ResourceStatusResponse(), $this->server->_LastResponse);
	}

	public function testGetsStatusReasons()
	{
		$reasons = array(new ResourceStatusReason(1, ResourceStatus::AVAILABLE));

		$this->repository->expects($this->once())
						 ->method('GetStatusReasons')
						 ->will($this->returnValue($reasons));

		$this->service->GetStatusReasons();

		$this->assertEquals(new ResourceStatusReasonsResponse($this->server, $reasons), $this->server->_LastResponse);
	}

	public function testGetsAllResourceAvailability()
	{
		$resourceId1 = 1;
		$resourceId2 = 2;
		$resourceId3 = 3;

		$startTime = Date::Now()
						 ->AddHours(-1);
		$endTime = Date::Now()
					   ->AddHours(1);
		$resources = array(new FakeBookableResource($resourceId1), new FakeBookableResource($resourceId2), new FakeBookableResource($resourceId3));

		$this->repository->expects($this->once())
						 ->method('GetResourceList')
						 ->will($this->returnValue($resources));

		$conflicting = new TestReservationItemView(1, $startTime, $endTime, $resourceId1);
		$upcoming = new TestReservationItemView(2, $endTime, $endTime->AddHours(3), $resourceId1);
		$upcoming2 = new TestReservationItemView(3, $endTime->AddHours(3), $endTime->AddHours(4), $resourceId1);
		$upcoming3 = new TestReservationItemView(4, $endTime->AddHours(5), $endTime->AddHours(6), $resourceId1);

		$upcoming4 = new TestReservationItemView(5, $endTime->AddHours(3), $endTime->AddHours(3), $resourceId2);

		$upcoming5 = new TestReservationItemView(6, $startTime, $endTime->AddHours(2), $resourceId3);
		$reservations = array($conflicting, $upcoming, $upcoming2, $upcoming3, $upcoming4, $upcoming5);

		$endDate = Date::Now()
					   ->AddDays(7);
		$this->reservationRepository->expects($this->once())
									->method('GetReservationList')
									->with($this->equalTo(Date::Now()->AddDays(-1)),
										   $this->equalTo($endDate))
									->will($this->returnValue($reservations));

		$this->service->GetAvailability();

		$resources = array(
			new ResourceAvailabilityResponse($this->server, $resources[0], $conflicting, $upcoming, $endTime->AddHours(4), $endDate),
			new ResourceAvailabilityResponse($this->server, $resources[1], null, $upcoming2, null, $endDate),
			new ResourceAvailabilityResponse($this->server, $resources[2], $upcoming5, null, $upcoming5->GetEndDate(), $endDate),
		);

		$this->assertEquals(new ResourcesAvailabilityResponse($this->server, $resources), $this->server->_LastResponse);
	}

	public function testGetsAllResourceAvailabilityForARequestTime()
	{
		$date = Date::Parse('2014-01-01 04:30:00', 'America/Chicago');
		$this->server->SetQueryString(WebServiceQueryStringKeys::DATE_TIME, $date->ToIso());

		$resourceId1 = 1;
		$resourceId2 = 2;
		$resourceId3 = 3;

		$startTime = $date->AddHours(-1);
		$endTime = $date->AddHours(1);
		$resources = array(new FakeBookableResource($resourceId1), new FakeBookableResource($resourceId2), new FakeBookableResource($resourceId3));

		$this->repository->expects($this->once())
						 ->method('GetResourceList')
						 ->will($this->returnValue($resources));

		$conflicting = new TestReservationItemView(1, $startTime, $endTime, $resourceId1);
		$upcoming = new TestReservationItemView(2, $endTime, $endTime->AddHours(3), $resourceId1);
		$upcoming2 = new TestReservationItemView(3, $endTime->AddHours(3), $endTime->AddHours(4), $resourceId1);
		$upcoming3 = new TestReservationItemView(4, $endTime->AddHours(5), $endTime->AddHours(6), $resourceId1);

		$upcoming4 = new TestReservationItemView(5, $endTime->AddHours(3), $endTime->AddHours(3), $resourceId2);

		$upcoming5 = new TestReservationItemView(6, $startTime, $endTime->AddHours(2), $resourceId3);
		$reservations = array($conflicting, $upcoming, $upcoming2, $upcoming3, $upcoming4, $upcoming5);

		$endDate = $date->AddDays(7);
		$this->reservationRepository->expects($this->once())
									->method('GetReservationList')
									->with($this->equalTo($date->AddDays(-1)),
										   $this->equalTo($endDate))
									->will($this->returnValue($reservations));

		$this->service->GetAvailability();

		$resources = array(
			new ResourceAvailabilityResponse($this->server, $resources[0], $conflicting, $upcoming, $endTime->AddHours(4), $endDate),
			new ResourceAvailabilityResponse($this->server, $resources[1], null, $upcoming2, null, $endDate),
			new ResourceAvailabilityResponse($this->server, $resources[2], $upcoming5, null, $upcoming5->GetEndDate(), $endDate),
		);

		$this->assertEquals(new ResourcesAvailabilityResponse($this->server, $resources), $this->server->_LastResponse);
	}

	public function testGetsSingleResourceAvailability()
	{
		$resourceId1 = 1;

		$startTime = Date::Now()
						 ->AddHours(-1);
		$endTime = Date::Now()
					   ->AddHours(1);
		$resource = new FakeBookableResource($resourceId1);

		$this->repository->expects($this->once())
						 ->method('LoadById')
						 ->with($this->equalTo($resourceId1))
						 ->will($this->returnValue($resource));

		$conflicting = new TestReservationItemView(1, $startTime, $endTime, $resourceId1);
		$upcoming = new TestReservationItemView(2, $endTime, $endTime->AddHours(3), $resourceId1);
		$upcoming2 = new TestReservationItemView(3, $endTime->AddHours(3), $endTime->AddHours(4), $resourceId1);
		$upcoming3 = new TestReservationItemView(4, $endTime->AddHours(5), $endTime->AddHours(6), $resourceId1);

		$reservations = array($conflicting, $upcoming, $upcoming2, $upcoming3);

		$endDate = Date::Now()->AddDays(7);
		$this->reservationRepository->expects($this->once())
									->method('GetReservationList')
									->with($this->equalTo(Date::Now()->AddDays(-1)),
										   $this->equalTo($endDate),
										   $this->isEmpty(),
										   $this->isEmpty(),
										   $this->isEmpty(),
										   $this->equalTo($resourceId1))
									->will($this->returnValue($reservations));

		$this->service->GetAvailability($resourceId1);

		$resources = array(
			new ResourceAvailabilityResponse($this->server, $resource, $conflicting, $upcoming, $endTime->AddHours(4), $endDate)
		);

		$this->assertEquals(new ResourcesAvailabilityResponse($this->server, $resources), $this->server->_LastResponse);
	}

	public function testGetsSingleResourceAvailabilityForARequestTime()
	{
		$date = Date::Parse('2014-01-01 04:30:00', 'America/Chicago');
		$this->server->SetQueryString(WebServiceQueryStringKeys::DATE_TIME, $date->ToIso());
		$resourceId1 = 1;

		$startTime = $date->AddHours(-1);
		$endTime = $date->AddHours(1);
		$resource = new FakeBookableResource($resourceId1);

		$this->repository->expects($this->once())
						 ->method('LoadById')
						 ->with($this->equalTo($resourceId1))
						 ->will($this->returnValue($resource));

		$conflicting = new TestReservationItemView(1, $startTime, $endTime, $resourceId1);
		$upcoming = new TestReservationItemView(2, $endTime, $endTime->AddHours(3), $resourceId1);
		$upcoming2 = new TestReservationItemView(3, $endTime->AddHours(3), $endTime->AddHours(4), $resourceId1);
		$upcoming3 = new TestReservationItemView(4, $endTime->AddHours(5), $endTime->AddHours(6), $resourceId1);

		$reservations = array($conflicting, $upcoming, $upcoming2, $upcoming3);

		$endDate = $date->AddDays(7);
		$this->reservationRepository->expects($this->once())
									->method('GetReservationList')
									->with($this->equalTo($date->AddDays(-1)),
										   $this->equalTo($endDate),
										   $this->isEmpty(),
										   $this->isEmpty(),
										   $this->isEmpty(),
										   $this->equalTo($resourceId1))
									->will($this->returnValue($reservations));

		$this->service->GetAvailability($resourceId1);

		$resources = array(
			new ResourceAvailabilityResponse($this->server, $resource, $conflicting, $upcoming, $endTime->AddHours(4), $endDate)
		);

		$this->assertEquals(new ResourcesAvailabilityResponse($this->server, $resources), $this->server->_LastResponse);
	}
}