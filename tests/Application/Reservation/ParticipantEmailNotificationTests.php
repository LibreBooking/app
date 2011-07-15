<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ParticipantEmailNotificationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testSendsReservationCreatedEmailIfThereAreNewParticipants()
	{
		$ownerId = 828;
		$owner = new User();
		$participantId1 = 50;
		$participant1 = new User();
		$participantId2 = 60;
		$participant2 = new User();
		
		$series = new TestReservationSeries();
		$series->WithOwnerId($ownerId);
		$series->WithAddedParticipants(array($participantId1, $participantId2));

		$userRepo = $this->getMock('IUserRepository');

		$userRepo->expects($this->at(0))
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($owner));

		$userRepo->expects($this->at(1))
			->method('LoadById')
			->with($this->equalTo($participantId1))
			->will($this->returnValue($participant1));
		
		$userRepo->expects($this->at(2))
			->method('LoadById')
			->with($this->equalTo($participantId2))
			->will($this->returnValue($participant2));

		$notification = new ParticipantAddedEmailNotification($userRepo);
		$notification->Notify($series);
		
		$this->assertEquals(2, count($this->fakeEmailService->_Messages));
		$lastExpectedMessage = new ParticipantAddedEmail($owner, $participant2, $series);
		$this->assertEquals($lastExpectedMessage, $this->fakeEmailService->_LastMessage);

	}
	
	public function testSendsReservationUpdatedEmailIfThereAreNewParticipants()
	{
		$this->markTestIncomplete('2011.07.14');
	}
}


?>