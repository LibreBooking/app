<?php
/**
Copyright 2011-2016 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationDeletedEmail.php');

class OwnerEmailNotificationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testSendsReservationCreatedEmailIfUserWantsIt()
	{
		$ownerId = 100;
		$resourceId = 200;

		$resource = new FakeBookableResource($resourceId, 'name');

		$reservation = new TestReservationSeries();
		$reservation->WithOwnerId($ownerId);
		$reservation->WithResource($resource);
        $reservation->WithCurrentInstance(new TestReservation());

		$userRepo = $this->getMock('IUserRepository');
		$attributeRepo = new FakeAttributeRepository();

		$user = $this->LoadsUser($userRepo, $ownerId);

		$notification = new OwnerEmailCreatedNotification($userRepo, $attributeRepo);
		$notification->Notify($reservation);

		$expectedMessage = new ReservationCreatedEmail($user, $reservation, null, $attributeRepo);

		$lastMessage = $this->fakeEmailService->_LastMessage;
        $body = $lastMessage->Body();
        $this->assertInstanceOf('ReservationCreatedEmail', $lastMessage);
        $this->assertNotEmpty($lastMessage->AttachmentContents());
//		$this->assertEquals($expectedMessage, $lastMessage);
	}

	public function testSendsReservationUpdatedEmailIfUserWantsIt()
	{
		$event = new ReservationUpdatedEvent();
		$ownerId = 100;
		$resourceId = 200;

		$resource = new FakeBookableResource($resourceId, 'name');

		$reservation = new ExistingReservationSeries();
		$reservation->WithOwner($ownerId);
		$reservation->WithPrimaryResource($resource);

		$userRepo = $this->getMock('IUserRepository');
		$attributeRepo = $this->getMock('IAttributeRepository');

		$user = $this->LoadsUser($userRepo, $ownerId);

		$notification = new OwnerEmailUpdatedNotification($userRepo, $attributeRepo);
		$notification->Notify($reservation);

		$expectedMessage = new ReservationUpdatedEmail($user, $reservation, null, $attributeRepo);

		$lastMessage = $this->fakeEmailService->_LastMessage;
		$this->assertInstanceOf('ReservationUpdatedEmail', $lastMessage);
//		$this->assertEquals($expectedMessage, $lastMessage);
	}

    public function testSendsReservationDeletedEmailIfUserWantsIt()
    {
        $ownerId = 100;
        $resourceId = 200;

        $resource = new FakeBookableResource($resourceId, 'name');

        $reservation = new ExistingReservationSeries();
        $reservation->WithOwner($ownerId);
        $reservation->WithPrimaryResource($resource);

        $userRepo = $this->getMock('IUserRepository');
		$attributeRepo = $this->getMock('IAttributeRepository');

        $user = $this->LoadsUser($userRepo, $ownerId);

        $notification = new OwnerEmailDeletedNotification($userRepo, $attributeRepo);
        $notification->Notify($reservation);

        $expectedMessage = new ReservationDeletedEmail($user, $reservation, null, $attributeRepo);

        $lastMessage = $this->fakeEmailService->_LastMessage;
        $this->assertInstanceOf('ReservationDeletedEmail', $lastMessage);
    }

//	public function AsksUser($user, $event)
//	{
//		$user->expects($this->once())
//			->method('WantsEventEmail')
//			->with($this->equalTo($event))
//			->will($this->returnValue(true));
//	}

	public function LoadsUser($userRepo, $ownerId)
	{
		$user = new FakeUser();
        $user->_WantsEmail = true;

		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));

		return $user;
	}
}