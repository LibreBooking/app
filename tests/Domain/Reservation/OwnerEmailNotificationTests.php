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
		$title = 'some cool title';
		$description = 'some cool description';
		$resourceName = 'resource 1';
		$userEmailAddress = 'user@email.com';
		
		$startDate = Date::Parse('2010-09-29 05:20:00', 'UTC');
		$endDate = Date::Parse('2010-10-01 22:20:00', 'UTC');
		
		$duration = new DateRange($startDate, $endDate);
		$reservation = new Reservation();
		$reservation->Update($ownerId, $resourceId, $title, $description);
		$reservation->UpdateDuration($duration);
		
		$user = new User();
		$resource = new FakeResource($resourceId, $resourceName);
		
		$emailMessage = new ReservationCreatedEmail();
		
		$userRepo = $this->getMock('IUserRepository');
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));
			
		$resourceRepo = $this->getMock('IUserRepository');
		$resourceRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource));
		
		$emailService = $this->getMock('IEmailService');
		
		// Resolve from ServiceLocator?
		$emailService->expects($this->once())
			->method('Send')
			->with($this->equalTo($userEmailAddress, $emailMessage));
			
		$notification = new OwnerEmailNotificaiton($userRepo, $resourceRepo);
		$notification->Notify($reservation);
	}
}
?>