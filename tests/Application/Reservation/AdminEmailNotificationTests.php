<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

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
	
	public function testSendsReservationCreatedEmailIfAdminWantsIt()
	{
		$ownerId = 100;
		$resourceId = 200;

		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, 
										ConfigKeys::RESERVATION_NOTIFY_CREATED, 
										'true');
		
		$reservation = new TestReservationSeries();
		$reservation->WithOwnerId($ownerId);
		$reservation->WithResourceId($resourceId);
		
		$user = $this->getMock('User');
		$admin1 = $this->getMock('User');
		$admin2 = $this->getMock('User');
		$admins = array($admin1, $admin2);
		
		$resource = new FakeResource($resourceId, 'name');
			
		$userRepo = $this->getMock('IUserRepository');
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));
		
		$userRepo->expects($this->once())
			->method('GetResourceAdmins')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($admins));
			
		$resourceRepo = $this->getMock('IResourceRepository');
		$resourceRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource));
			
		$notification = new AdminEmailCreatedNotificaiton($userRepo, $resourceRepo);
		$notification->Notify($reservation);
		
		$expectedMessage1 = new ReservationCreatedEmailAdmin($admin1, $user, $reservation, $resource);
		$expectedMessage2 = new ReservationCreatedEmailAdmin($admin2, $user, $reservation, $resource);
		
		$this->assertEquals(count($admins), count($this->fakeEmailService->_Messages));
		
		$this->assertEquals($expectedMessage1, $this->fakeEmailService->_Messages[0]);
		$this->assertEquals($expectedMessage2, $this->fakeEmailService->_Messages[1]);
	}
	
	public function testSendsReservationUpdatedEmailIfAdminWantsIt()
	{
		$ownerId = 100;
		$resourceId = 200;

		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, 
										ConfigKeys::RESERVATION_NOTIFY_UPDATED, 
										'true');
		
		$reservation = new ExistingReservationSeries();
		$reservation->WithOwner($ownerId);
		$reservation->WithPrimaryResource($resourceId);
		
		$user = $this->getMock('User');
		$admin1 = $this->getMock('User');
		$admin2 = $this->getMock('User');
		$admins = array($admin1, $admin2);
		
		$resource = new FakeResource($resourceId, 'name');
			
		$userRepo = $this->getMock('IUserRepository');
		$userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($user));
		
		$userRepo->expects($this->once())
			->method('GetResourceAdmins')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($admins));
			
		$resourceRepo = $this->getMock('IResourceRepository');
		$resourceRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource));
			
		$notification = new AdminEmailCreatedNotificaiton($userRepo, $resourceRepo);
		$notification->Notify($reservation);
		
		$expectedMessage1 = new ReservationUpdatedEmailAdmin($admin1, $user, $reservation, $resource);
		$expectedMessage2 = new ReservationUpdatedEmailAdmin($admin2, $user, $reservation, $resource);
		
		$this->assertEquals(count($admins), count($this->fakeEmailService->_Messages));
		
		$this->assertEquals($expectedMessage1, $this->fakeEmailService->_Messages[0]);
		$this->assertEquals($expectedMessage2, $this->fakeEmailService->_Messages[1]);
	}
	
	public function testNothingSentIfConfiguredOff()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, 
										ConfigKeys::RESERVATION_NOTIFY_CREATED, 
										'false');
										
		$notification = new AdminEmailNotificaiton($this->getMock('IUserRepository'), $this->getMock('IResourceRepository'));
		$notification->Notify(new TestReservationSeries());
		
		$this->assertEquals(0, count($this->fakeEmailService->_Messages));
	}
}
?>