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

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationDeletedEmail.php');

require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

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
		$event = new ReservationCreatedEvent();
		$ownerId = 100;
		$resourceId = 200;

		$resource = new FakeBookableResource($resourceId, 'name');
		
		$reservation = new TestReservationSeries();
		$reservation->WithOwnerId($ownerId);
		$reservation->WithResource($resource);
	
		$userRepo = $this->getMock('IUserRepository');
		
		$user = $this->LoadsUser($userRepo, $ownerId);
		$this->AsksUser($user, $event);
			
		$notification = new OwnerEmailCreatedNotification($userRepo);
		$notification->Notify($reservation);
		
		$expectedMessage = new ReservationCreatedEmail($user, $reservation);
		
		$lastMessage = $this->fakeEmailService->_LastMessage;
        $this->assertInstanceOf('ReservationCreatedEmail', $lastMessage);
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
		
		$user = $this->LoadsUser($userRepo, $ownerId);
		$this->AsksUser($user, $event);
			
		$notification = new OwnerEmailUpdatedNotification($userRepo);
		$notification->Notify($reservation);
		
		$expectedMessage = new ReservationUpdatedEmail($user, $reservation);
		
		$lastMessage = $this->fakeEmailService->_LastMessage;
		$this->assertInstanceOf('ReservationUpdatedEmail', $lastMessage);
//		$this->assertEquals($expectedMessage, $lastMessage);
	}

    public function testSendsReservationDeletedEmailIfUserWantsIt()
    {
        $event = new ReservationDeletedEvent();
        $ownerId = 100;
        $resourceId = 200;

        $resource = new FakeBookableResource($resourceId, 'name');

        $reservation = new ExistingReservationSeries();
        $reservation->WithOwner($ownerId);
        $reservation->WithPrimaryResource($resource);

        $userRepo = $this->getMock('IUserRepository');

        $user = $this->LoadsUser($userRepo, $ownerId);
        $this->AsksUser($user, $event);

        $notification = new OwnerEmailDeletedNotification($userRepo);
        $notification->Notify($reservation);

        $expectedMessage = new ReservationDeletedEmail($user, $reservation);

        $lastMessage = $this->fakeEmailService->_LastMessage;
        $this->assertInstanceOf('ReservationDeletedEmail', $lastMessage);
    }
	
	public function AsksUser($user, $event)
	{
		$user->expects($this->once())
			->method('WantsEventEmail')
			->with($this->equalTo($event))
			->will($this->returnValue(true));
	}
	
	public function LoadsUser($userRepo, $ownerId)
	{
		$user = $this->getMock('User');
		
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));
			
		return $user;
	}
}
?>