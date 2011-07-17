<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class InvitationEmailNotificationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testSendsInvitationEmailToNewInvitees()
	{
		$ownerId = 828;
		$owner = new User();
		$inviteeId1 = 50;
		$invitee1 = new User();
		$inviteeId2 = 60;
		$invitee2 = new User();

		$series = new TestReservationSeries();
		$series->WithOwnerId($ownerId);
		$series->WithAddedInvitees(array($inviteeId1, $inviteeId2));

		$userRepo = $this->getMock('IUserRepository');

		$userRepo->expects($this->at(0))
			->method('LoadById')
			->with($this->equalTo($ownerId))
			->will($this->returnValue($owner));

		$userRepo->expects($this->at(1))
			->method('LoadById')
			->with($this->equalTo($inviteeId1))
			->will($this->returnValue($invitee1));

		$userRepo->expects($this->at(2))
			->method('LoadById')
			->with($this->equalTo($inviteeId2))
			->will($this->returnValue($invitee2));

		$notification = new InviteeAddedEmailNotification($userRepo);
		$notification->Notify($series);

		$this->assertEquals(2, count($this->fakeEmailService->_Messages));
		$lastExpectedMessage = new InviteeAddedEmail($owner, $invitee2, $series);
		$this->assertEquals($lastExpectedMessage, $this->fakeEmailService->_LastMessage);

	}

	public function testSendsReservationUpdatedEmailToExistingInvitees()
	{
		$this->markTestIncomplete('2011.07.14');
	}
}
?>