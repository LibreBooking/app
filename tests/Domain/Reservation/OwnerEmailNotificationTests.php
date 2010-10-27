<?php
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

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
	
	public function testSendsReservationEmailIfUserWantsIt()
	{
		$ownerId = 100;
		$resourceId = 200;

		$reservation = new Reservation();
		$reservation->Update($ownerId, $resourceId, null, null);

		$user = $this->getMock('User');
		$resource = new FakeResource($resourceId, 'name');
		
		$user->expects($this->once())
			->method('WantsEventEmail')
			->with($this->equalTo(new ReservationCreatedEvent()))
			->will($this->returnValue(true));
			
		$userRepo = $this->getMock('IUserRepository');
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));
			
		$resourceRepo = $this->getMock('IResourceRepository');
		$resourceRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource));
			
		$notification = new OwnerEmailNotificaiton($userRepo, $resourceRepo);
		$notification->Notify($reservation);
		
		$expectedMessage = new ReservationCreatedEmail($user, $reservation, $resource);
		
		$lastMessage = $this->fakeEmailService->_LastMessage;
		$this->assertEquals($expectedMessage, $lastMessage);
	}
}
?>