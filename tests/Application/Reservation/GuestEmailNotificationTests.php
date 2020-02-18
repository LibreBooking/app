<?php
/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

class GuestEmailNotificationTests extends TestBase
{
	public function setUp(): void
	{
		parent::setup();
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testSendsReservationCreatedEmailIfThereAreNewParticipants()
	{
		$ownerId = 828;
		$owner = new User();

		$guest1 = 'g1@email.com';
		$guest2 = 'g2@email.com';

		$instance1 = new TestReservation();
		$instance1->WithInvitedGuest('some@one.com');
		$instance1->ChangeInvitedGuests(array('some@one.com', $guest1, $guest2));

		$series = new TestReservationSeries();
		$series->WithOwnerId($ownerId);
		$series->WithCurrentInstance($instance1);

		$userRepo = $this->createMock('IUserRepository');
		$attributeRepo = $this->createMock('IAttributeRepository');

		$userRepo->expects($this->at(0))
				 ->method('LoadById')
				 ->with($this->equalTo($ownerId))
				 ->will($this->returnValue($owner));

		$notification = new GuestAddedEmailNotification($userRepo, $attributeRepo);
		$notification->Notify($series);

		$this->assertEquals(2, count($this->fakeEmailService->_Messages));
		// create it just to make sure it doesnt blow up
		$lastExpectedMessage = new GuestAddedEmail($owner, $guest2, $series, $attributeRepo, $userRepo);
		$this->assertInstanceOf('GuestAddedEmail', $this->fakeEmailService->_LastMessage);
		$this->assertEquals($guest2, $this->fakeEmailService->_LastMessage->To()[0]->Address());
	}

	public function testSendsReservationDeletedEmails()
	{
		$ownerId = 828;
		$owner = new User();

		$guest1 = 'g1@email.com';
		$guest2 = 'g2@email.com';

		$guestUser = new User();
		$guestUser->ChangeEmailAddress($guest2);

		$instance1 = new TestReservation();
		$instance1->WithParticipatingGuest($guest1);
		$instance1->WithParticipatingGuest($guest2);

		$series = new TestReservationSeries();
		$series->WithOwnerId($ownerId);
		$series->WithCurrentInstance($instance1);

		$userRepo = $this->createMock('IUserRepository');
		$attributeRepo = $this->createMock('IAttributeRepository');

		$userRepo->expects($this->at(0))
				 ->method('LoadById')
				 ->with($this->equalTo($ownerId))
				 ->will($this->returnValue($owner));

		$userRepo->expects($this->at(1))
				 ->method('LoadByUsername')
				 ->with($this->equalTo($guest1))
				 ->will($this->returnValue($guestUser));

		$userRepo->expects($this->at(2))
				 ->method('LoadByUsername')
				 ->with($this->equalTo($guest2))
				 ->will($this->returnValue($guestUser));

		$notification = new GuestDeletedEmailNotification($userRepo, $attributeRepo);
		$notification->Notify($series);

		$this->assertEquals(2, count($this->fakeEmailService->_Messages));
		$this->assertInstanceOf('GuestDeletedEmail', $this->fakeEmailService->_LastMessage);
		$this->assertEquals($guest2, $this->fakeEmailService->_LastMessage->To()[0]->Address());
	}

	public function testSendsReservationUpdatedEmailToExistingParticipants()
	{
		$ownerId = 828;
		$owner = new User();

		$guest1 = 'g1@email.com';
		$guest2 = 'g2@email.com';

		$guestUser = new User();
		$guestUser->ChangeEmailAddress($guest2);

		$instance1 = new TestReservation();
		$instance1->WithParticipatingGuest($guest1);
		$instance1->WithParticipatingGuest($guest2);
		$instance1->ChangeInvitedGuests(array('new@1.com', 'new@2.com' ));

		$series = new TestReservationSeries();
		$series->WithOwnerId($ownerId);
		$series->WithCurrentInstance($instance1);

		$userRepo = $this->createMock('IUserRepository');
		$attributeRepo = $this->createMock('IAttributeRepository');

		$userRepo->expects($this->at(0))
				 ->method('LoadById')
				 ->with($this->equalTo($ownerId))
				 ->will($this->returnValue($owner));

		$userRepo->expects($this->at(1))
				 ->method('LoadByUsername')
				 ->with($this->equalTo($guest1))
				 ->will($this->returnValue($guestUser));

		$userRepo->expects($this->at(2))
				 ->method('LoadByUsername')
				 ->with($this->equalTo($guest2))
				 ->will($this->returnValue($guestUser));

		$notification = new GuestUpdatedEmailNotification($userRepo, $attributeRepo);
		$notification->Notify($series);

		$this->assertEquals(4, count($this->fakeEmailService->_Messages));
		$this->assertInstanceOf('GuestAddedEmail', $this->fakeEmailService->_Messages[0]);
		$this->assertInstanceOf('GuestUpdatedEmail', $this->fakeEmailService->_Messages[2]);
	}
}