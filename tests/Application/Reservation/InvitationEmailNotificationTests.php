<?php
/**
Copyright 2011-2017 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

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

		$instance1 = new TestReservation();
		$instance1->WithAddedInvitees(array($inviteeId1, $inviteeId2));

		$series = new TestReservationSeries();
		$series->WithCurrentInstance($instance1);
		$series->WithOwnerId($ownerId);

		$userRepo = $this->getMock('IUserRepository');
		$attributeRepo = $this->getMock('IAttributeRepository');

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

		$notification = new InviteeAddedEmailNotification($userRepo, $attributeRepo);
		$notification->Notify($series);

		$this->assertEquals(2, count($this->fakeEmailService->_Messages));
		$lastExpectedMessage = new InviteeAddedEmail($owner, $invitee2, $series, $attributeRepo);
        $this->assertInstanceOf('InviteeAddedEmail', $this->fakeEmailService->_LastMessage);
//		$this->assertEquals($lastExpectedMessage, $this->fakeEmailService->_LastMessage);

	}
}