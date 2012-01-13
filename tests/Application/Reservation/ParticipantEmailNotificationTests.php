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

		$instance1 = new TestReservation();
		$instance1->WithAddedParticipants(array($participantId1, $participantId2));
		
		$series = new TestReservationSeries();
		$series->WithOwnerId($ownerId);
		$series->WithCurrentInstance($instance1);

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
        $this->assertInstanceOf('ParticipantAddedEmail', $this->fakeEmailService->_LastMessage);
//		$this->assertEquals($lastExpectedMessage, $this->fakeEmailService->_LastMessage);
	}
	
	public function testSendsReservationUpdatedEmailToExistingParticipants()
	{
		$this->markTestIncomplete('2011.07.15');
	}

	public function testSendsReservationDeletedEmailToExistingParticipants()
	{
		$this->markTestIncomplete('2011.07.15');
	}
}


?>