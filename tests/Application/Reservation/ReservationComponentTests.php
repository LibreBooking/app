<?php
/**
Copyright 2012 Nick Korbel

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

		$this->userId = $this->fakeUser->UserId;

		$this->scheduleRepository = $this->getMock('IScheduleRepository');
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

		$this->initializer->expects($this->once())
				->method('GetOwnerId')
				->will($this->returnValue($this->userId));

		$this->initializer->expects($this->once())
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

		$this->initializer->expects($this->once())
						->method('SetCanChangeUser')
						->with($this->equalTo(true));

		$this->initializer->expects($this->once())
						->method('ShowUserDetails')
						->with($this->equalTo(true));

		$this->initializer->expects($this->once())
						->method('SetReservationUser')
						->with($this->equalTo($userDto));

		$binder = new ReservationUserBinder($this->userRepository, $this->reservationAuthorization);
		$binder->Bind($this->initializer);
	}

	public function testBindsResourceData()
	{
		$requestedScheduleId = 10;
		$requestedResourceId = 90;

		$this->initializer->expects($this->once())
						->method('GetScheduleId')
						->will($this->returnValue($requestedScheduleId));

		$this->initializer->expects($this->once())
						->method('GetResourceId')
						->will($this->returnValue($requestedResourceId));

		$this->initializer->expects($this->once())
						->method('CurrentUser')
						->will($this->returnValue($this->fakeUser));

		$bookedResource = new ResourceDto($requestedResourceId, 'resource 1');
		$otherResource = new ResourceDto(2, 'resource 2');
		$otherResource2 = new ResourceDto(100, 'something', false);
		$resourceList = array($otherResource, $bookedResource, $otherResource2);

		$this->resourceService->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($requestedScheduleId), $this->equalTo(true), $this->equalTo($this->fakeUser))
			->will($this->returnValue($resourceList));

		// accessories
		$accessoryList = array(new AccessoryDto(1, 'a1', 30), new AccessoryDto(2, 'a2', 20));
		$this->resourceService->expects($this->once())
			->method('GetAccessories')
			->will($this->returnValue($accessoryList));

		$resourceListWithoutReservationResource = array($otherResource, $otherResource2);
		$this->initializer->expects($this->once())
			->method('BindAvailableResources')
			->with($this->equalTo($resourceListWithoutReservationResource));

		$this->initializer->expects($this->once())
			->method('ShowAdditionalResources')
			->with($this->equalTo(true));

		$this->initializer->expects($this->once())
			->method('BindAvailableAccessories')
			->with($this->equalTo($accessoryList));

		$this->initializer->expects($this->once())
					->method('SetReservationResource')
					->with($this->equalTo($bookedResource));

		$binder = new ReservationResourceBinder($this->resourceService);
		$binder->Bind($this->initializer);
	}
}

?>