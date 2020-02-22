<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ReservationNotificationFactory implements IReservationNotificationFactory
{
    /**
     * @var array|string[]
     */
    private $creationStrategies = array();

    public function __construct()
    {
        $this->creationStrategies[ReservationAction::Approve] = 'CreateApproveService';
        $this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
        $this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
        $this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
        $this->creationStrategies[ReservationAction::Checkin] = 'CreateCheckinService';
        $this->creationStrategies[ReservationAction::Checkout] = 'CreateCheckoutService';
    }

    public function Create($reservationAction, $userSession)
    {
        if (array_key_exists($reservationAction, $this->creationStrategies))
        {
            $createMethod = $this->creationStrategies[$reservationAction];
            return $this->$createMethod($userSession);
        }

        return new NullReservationNotificationService();
    }

    private function CreateAddService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostAddService($userSession);
    }

    private function CreateApproveService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostApproveService($userSession);
    }

    private function CreateDeleteService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostDeleteService($userSession);
    }

    private function CreateUpdateService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostUpdateService($userSession);
    }

    private function CreateCheckinService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostCheckinService($userSession);
    }

    private function CreateCheckoutService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostCheckoutService($userSession);
    }
}

class NullReservationNotificationService implements IReservationNotificationService
{
    /**
     * @param ReservationSeries $reservationSeries
     */
    function Notify($reservationSeries)
    {
        // no-op
    }
}