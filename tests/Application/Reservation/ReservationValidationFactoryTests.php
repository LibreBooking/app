<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class ReservationValidationFactoryTests extends TestBase
{

    public function testLoadsAddRulesFromPlugins()
    {
        $preResPlugin = $this->createMock('IPreReservationFactory');
        $pluginManager = new FakePluginManager();
        $pluginManager->preResPlugin = $preResPlugin;
        $validationService = $this->createMock('IReservationValidationService');

        PluginManager::SetInstance($pluginManager);

        $preResPlugin->expects($this->once())
                ->method('CreatePreAddService')
                ->with($this->fakeUser)
                ->will($this->returnValue($validationService));

        $reservationValidationFactory = new ReservationValidationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Create, $this->fakeUser);

        $this->assertEquals($validationService, $actual);
    }

    public function testLoadsUpdateRulesFromPlugins()
    {
        $preResPlugin = $this->createMock('IPreReservationFactory');
        $pluginManager = new FakePluginManager();
        $pluginManager->preResPlugin = $preResPlugin;
        $validationService = $this->createMock('IReservationValidationService');

        PluginManager::SetInstance($pluginManager);

        $preResPlugin->expects($this->once())
                ->method('CreatePreUpdateService')
                ->with($this->fakeUser)
                ->will($this->returnValue($validationService));

        $reservationValidationFactory = new ReservationValidationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Update, $this->fakeUser);

        $this->assertEquals($validationService, $actual);
    }

    public function testLoadsDeleteRulesFromPlugins()
    {
        $preResPlugin = $this->createMock('IPreReservationFactory');
        $pluginManager = new FakePluginManager();
        $pluginManager->preResPlugin = $preResPlugin;
        $validationService = $this->createMock('IReservationValidationService');

        PluginManager::SetInstance($pluginManager);

        $preResPlugin->expects($this->once())
                ->method('CreatePreDeleteService')
                ->with($this->fakeUser)
                ->will($this->returnValue($validationService));

        $reservationValidationFactory = new ReservationValidationFactory();
        $actual = $reservationValidationFactory->Create(ReservationAction::Delete, $this->fakeUser);

        $this->assertEquals($validationService, $actual);
    }
}

?>