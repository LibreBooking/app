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

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmailAdmin.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

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

        $resource = new FakeBookableResource($resourceId, 'name');

        $reservation = new TestReservationSeries();
        $reservation->WithOwnerId($ownerId);
        $reservation->WithResource($resource);

        $owner = new FakeUser($ownerId);
        $admin1 = new UserDto(1, 'f', 'l', 'e');
        $admin2 = new UserDto(2, 'f', 'l', 'e');
        $admin3 = new UserDto(3, 'f', 'l', 'e');
        $admin4 = new UserDto(4, 'f', 'l', 'e');
        $admin5 = new UserDto(5, 'f', 'l', 'e');
        $admin6 = new UserDto(6, 'f', 'l', 'e');

        $resourceAdmins = array($admin1, $admin2, $admin3);
        $appAdmins = array($admin3, $admin4, $admin1);
        $groupAdmins = array($admin5, $admin6, $admin2);

        $userRepo = $this->getMock('IUserRepository');
        $userRepo->expects($this->once())
                ->method('LoadById')
                ->with($this->equalTo($ownerId))
                ->will($this->returnValue($owner));

        $userRepo->expects($this->once())
                ->method('GetResourceAdmins')
                ->with($this->equalTo($resourceId))
                ->will($this->returnValue($resourceAdmins));

        $userRepo->expects($this->once())
                ->method('GetApplicationAdmins')
                ->will($this->returnValue($appAdmins));

        $userRepo->expects($this->once())
                ->method('GetGroupAdmins')
                ->with($this->equalTo($ownerId))
                ->will($this->returnValue($groupAdmins));

        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_RESOURCE_ADMINS);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_APPLICATION_ADMINS);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_GROUP_ADMINS);

        $notification = new AdminEmailCreatedNotification($userRepo, $userRepo);
        $notification->Notify($reservation);

        $expectedMessage1 = new ReservationCreatedEmailAdmin($admin1, $owner, $reservation, $resource);
        $expectedMessage2 = new ReservationCreatedEmailAdmin($admin2, $owner, $reservation, $resource);

        $this->assertEquals(6, count($this->fakeEmailService->_Messages));

        $this->isInstanceOf('ReservationCreatedEmailAdmin', $this->fakeEmailService->_Messages[0]);
        $this->isInstanceOf('ReservationCreatedEmailAdmin', $this->fakeEmailService->_Messages[1]);
    }

    public function testSendsReservationUpdatedEmailIfAdminWantsIt()
    {
        $ownerId = 100;
        $resourceId = 200;

        $resource = new FakeBookableResource($resourceId, 'name');

        $reservation = new ExistingReservationSeries();
        $reservation->WithOwner($ownerId);
        $reservation->WithPrimaryResource($resource);

        $owner = new FakeUser($ownerId);
        $admin1 = new UserDto(1, 'f', 'l', 'e');
        $admin2 = new UserDto(2, 'f', 'l', 'e');
        $admin3 = new UserDto(3, 'f', 'l', 'e');
        $admin4 = new UserDto(4, 'f', 'l', 'e');
        $admin5 = new UserDto(5, 'f', 'l', 'e');
        $admin6 = new UserDto(6, 'f', 'l', 'e');

        $resourceAdmins = array($admin1, $admin2, $admin3);
        $appAdmins = array($admin3, $admin4, $admin1);
        $groupAdmins = array($admin5, $admin6, $admin2);

        $userRepo = $this->getMock('IUserRepository');
        $userRepo->expects($this->once())
                ->method('LoadById')
                ->with($this->equalTo($ownerId))
                ->will($this->returnValue($owner));

        $userRepo->expects($this->once())
                ->method('GetResourceAdmins')
                ->with($this->equalTo($resourceId))
                ->will($this->returnValue($resourceAdmins));

        $userRepo->expects($this->once())
                ->method('GetApplicationAdmins')
                ->will($this->returnValue($appAdmins));

        $userRepo->expects($this->once())
                ->method('GetGroupAdmins')
                ->with($this->equalTo($ownerId))
                ->will($this->returnValue($groupAdmins));

        $this->EnableNotifyFor(ConfigKeys::NOTIFY_UPDATE_RESOURCE_ADMINS);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_UPDATE_APPLICATION_ADMINS);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_UPDATE_GROUP_ADMINS);

        $notification = new AdminEmailUpdatedNotification($userRepo, $userRepo);
        $notification->Notify($reservation);

        $expectedMessage1 = new ReservationUpdatedEmailAdmin($admin1, $owner, $reservation, $resource);
        $expectedMessage2 = new ReservationUpdatedEmailAdmin($admin2, $owner, $reservation, $resource);

        $this->assertEquals(6, count($this->fakeEmailService->_Messages), "send one per person, no duplicates");

        $this->isInstanceOf('ReservationUpdatedEmailAdmin', $this->fakeEmailService->_Messages[0]);
        $this->isInstanceOf('ReservationUpdatedEmailAdmin', $this->fakeEmailService->_Messages[1]);
    }

    public function testSendsReservationDeletedEmailIfAdminWantsIt()
        {
            $ownerId = 100;
            $resourceId = 200;

            $resource = new FakeBookableResource($resourceId, 'name');

            $reservation = new ExistingReservationSeries();
            $reservation->WithOwner($ownerId);
            $reservation->WithPrimaryResource($resource);

            $owner = new FakeUser($ownerId);
            $admin1 = new UserDto(1, 'f', 'l', 'e');
            $admin2 = new UserDto(2, 'f', 'l', 'e');
            $admin3 = new UserDto(3, 'f', 'l', 'e');
            $admin4 = new UserDto(4, 'f', 'l', 'e');
            $admin5 = new UserDto(5, 'f', 'l', 'e');
            $admin6 = new UserDto(6, 'f', 'l', 'e');

            $resourceAdmins = array($admin1, $admin2, $admin3);
            $appAdmins = array($admin3, $admin4, $admin1);
            $groupAdmins = array($admin5, $admin6, $admin2);

            $userRepo = $this->getMock('IUserRepository');
            $userRepo->expects($this->once())
                    ->method('LoadById')
                    ->with($this->equalTo($ownerId))
                    ->will($this->returnValue($owner));

            $userRepo->expects($this->once())
                    ->method('GetResourceAdmins')
                    ->with($this->equalTo($resourceId))
                    ->will($this->returnValue($resourceAdmins));

            $userRepo->expects($this->once())
                    ->method('GetApplicationAdmins')
                    ->will($this->returnValue($appAdmins));

            $userRepo->expects($this->once())
                    ->method('GetGroupAdmins')
                    ->with($this->equalTo($ownerId))
                    ->will($this->returnValue($groupAdmins));

            $this->EnableNotifyFor(ConfigKeys::NOTIFY_DELETE_RESOURCE_ADMINS);
            $this->EnableNotifyFor(ConfigKeys::NOTIFY_DELETE_APPLICATION_ADMINS);
            $this->EnableNotifyFor(ConfigKeys::NOTIFY_DELETE_GROUP_ADMINS);

            $notification = new AdminEmailDeletedNotification($userRepo, $userRepo);
            $notification->Notify($reservation);

            $expectedMessage1 = new ReservationDeletedEmailAdmin($admin1, $owner, $reservation, $resource);

            $this->assertEquals(6, count($this->fakeEmailService->_Messages), "send one per person, no duplicates");

            $this->isInstanceOf('ReservationDeletedEmailAdmin', $this->fakeEmailService->_Messages[0]);
            $this->isInstanceOf('ReservationDeletedEmailAdmin', $this->fakeEmailService->_Messages[1]);
        }

    public function testNothingSentIfConfiguredOff()
    {
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_RESOURCE_ADMINS, false);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_APPLICATION_ADMINS, false);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_GROUP_ADMINS, false);

        $notification = new AdminEmailCreatedNotification($this->getMock('IUserRepository'), $this->getMock('IUserViewRepository'));
        $notification->Notify(new TestReservationSeries());

        $this->assertEquals(0, count($this->fakeEmailService->_Messages));
    }

    private function EnableNotifyFor($configKey, $enabled = true)
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION_NOTIFY, $configKey, $enabled);
    }
}

?>