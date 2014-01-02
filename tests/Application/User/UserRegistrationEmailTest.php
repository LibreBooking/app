<?php
/**
Copyright 2011-2014 Nick Korbel, Paul Menchini

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

require_once(ROOT_DIR . 'lib/Email/Messages/AccountCreationEmail.php');

//require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
//require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

class UserRegistrationEmailTest extends TestBase
{
    public function setup()
    {
        parent::setup();
    }

    public function teardown()
    {
        parent::teardown();
    }

    public function testSendsUserRegistrationEmailIfAdminWantsIt()
    {
    }

    public function testNothingSentIfConfiguredOff()
    {
        /*
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_RESOURCE_ADMINS, false);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_APPLICATION_ADMINS, false);
        $this->EnableNotifyFor(ConfigKeys::NOTIFY_CREATE_GROUP_ADMINS, false);

        $notification = new AdminEmailCreatedNotification($this->getMock('IUserRepository'), $this->getMock('IUserViewRepository'));
        $notification->Notify(new TestReservationSeries());

        $this->assertEquals(0, count($this->fakeEmailService->_Messages));
        */
    }

    private function EnableNotifyFor($configKey, $enabled = true)
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION_NOTIFY, $configKey, $enabled);
    }
}

?>