<?php
/**
Copyright 2012-2018 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

class ReservationNotificationFactoryTests extends TestBase
{
    /**
     * @var IPostReservationFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $plugin;

    /**
     * @var IReservationNotificationService|PHPUnit_Framework_MockObject_MockObject
     */
    private $service;

    public function setup()
    {
		parent::setup();

        $this->plugin = $this->getMock('IPostReservationFactory');
        $pluginManager = new FakePluginManager();
        $pluginManager->postResPlugin = $this->plugin;
        $this->service = $this->getMock('IReservationNotificationService');

        PluginManager::SetInstance($pluginManager);
    }

    public function testLoadsAddFromPlugins()
    {
        $this->plugin->expects($this->once())
                ->method('CreatePostAddService')
                ->with($this->fakeUser)
                ->will($this->returnValue($this->service));

        $reservationValidationFactory = new ReservationNotificationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Create, $this->fakeUser);

        $this->assertEquals($this->service, $actual);
    }

    public function testLoadsUpdateRulesFromPlugins()
    {
        $this->plugin->expects($this->once())
                ->method('CreatePostUpdateService')
                ->with($this->fakeUser)
                ->will($this->returnValue($this->service));

        $reservationValidationFactory = new ReservationNotificationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Update, $this->fakeUser);

        $this->assertEquals($this->service, $actual);
    }

    public function testLoadsDeleteRulesFromPlugins()
    {
        $this->plugin->expects($this->once())
                ->method('CreatePostDeleteService')
                ->with($this->fakeUser)
                ->will($this->returnValue($this->service));

        $reservationValidationFactory = new ReservationNotificationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Delete, $this->fakeUser);

        $this->assertEquals($this->service, $actual);
    }


    public function testLoadsApproveRulesFromPlugins()
    {
        $this->plugin->expects($this->once())
                ->method('CreatePostApproveService')
                ->with($this->fakeUser)
                ->will($this->returnValue($this->service));

        $reservationValidationFactory = new ReservationNotificationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Approve, $this->fakeUser);

        $this->assertEquals($this->service, $actual);
    }
}

?>