<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmail.php');

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
		
		$expectedMessage = new ReservationCreatedEmail($user, $reservation, $resource);
		
		$lastMessage = $this->fakeEmailService->_LastMessage;
		$this->assertEquals($expectedMessage, $lastMessage);
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
		
		$expectedMessage = new ReservationUpdatedEmail($user, $reservation, $resource);
		
		$lastMessage = $this->fakeEmailService->_LastMessage;
		$this->assertEquals($expectedMessage, $lastMessage);
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