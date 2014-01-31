<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class ReservationValidationFactory implements IReservationValidationFactory
{
    /**
     * @var array|string[]
     */
    private $creationStrategies = array();

    public function __construct()
    {
        //$this->creationStrategies[ReservationAction::Approve] = 'CreateUpdateService';
        $this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
        $this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
        $this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
    }

    public function Create($reservationAction, $userSession)
    {
        if (array_key_exists($reservationAction, $this->creationStrategies))
        {
            $createMethod = $this->creationStrategies[$reservationAction];
            return $this->$createMethod($userSession);
        }

        return new NullReservationValidationService();
    }

    private function CreateAddService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
        return $factory->CreatePreAddService($userSession);
    }

    private function CreateUpdateService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
        return $factory->CreatePreUpdateService($userSession);
    }

    private function CreateDeleteService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
        return $factory->CreatePreDeleteService($userSession);
    }
}

class NullReservationValidationService implements IReservationValidationService
{
    /**
     * @param ReservationSeries $reservation
     * @return IReservationValidationResult
     */
    function Validate($reservation)
    {
        return new ReservationValidationResult();
    }
}