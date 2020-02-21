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

class ReservationValidationFactory implements IReservationValidationFactory
{
    /**
     * @var array|string[]
     */
    private $creationStrategies = array();

    public function __construct()
    {
        $this->creationStrategies[ReservationAction::Approve] = 'CreateApprovalService';
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

	private function CreateApprovalService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
		if (method_exists($factory,'CreatePreApprovalService'))
		{
			return $factory->CreatePreApprovalService($userSession);
		}
		return new NullReservationValidationService();
    }

    private function CreateCheckinService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
		if (method_exists($factory,'CreatePreCheckinService'))
		{
			return $factory->CreatePreCheckinService($userSession);
		}
		return new NullReservationValidationService();
    }

    private function CreateCheckoutService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
		if (method_exists($factory,'CreatePreCheckoutService'))
		{
			return $factory->CreatePreCheckoutService($userSession);
		}
		return new NullReservationValidationService();
    }
}

class NullReservationValidationService implements IReservationValidationService
{
    function Validate($reservation, $retryParameters = null)
    {
        return new ReservationValidationResult();
    }
}