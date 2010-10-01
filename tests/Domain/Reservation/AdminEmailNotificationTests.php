<?php
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

class AdminEmailNotificationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testSendsReservationEmailIfAdminWantsIt()
	{
		$ownerId = 100;
		$resourceId = 200;

		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, 
										ConfigKeys::RESERVATION_NOTIFY_CREATED, 
										'true');
		
		$reservation = new Reservation();
		$reservation->Update($ownerId, $resourceId, null, null);
		
		$user = $this->getMock('User');
		$admin = $this->getMock('User');
		$resource = new FakeResource($resourceId, 'name');
			
		$userRepo = $this->getMock('IUserRepository');
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));
		
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($adminId))
			->will($this->returnValue($admin));
			
		$resourceRepo = $this->getMock('IResourceRepository');
		$resourceRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource));
			
		$notification = new AdminEmailNotificaiton($userRepo, $resourceRepo);
		$notification->Notify($reservation);
		
		$expectedMessage = new ReservationCreatedEmail($user, $reservation, $resource);
		
		$lastMessage = $this->fakeEmailService->_LastMessage;
		$this->assertEquals($expectedMessage, $lastMessage);
	}
}
?>