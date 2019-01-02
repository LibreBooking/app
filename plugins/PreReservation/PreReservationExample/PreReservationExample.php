<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(dirname(__FILE__) . '/PreReservationExampleValidation.php');

class PreReservationExample implements IPreReservationFactory
{
	/**
     * @var PreReservationFactory
     */
    private $factoryToDecorate;

    public function __construct(PreReservationFactory $factoryToDecorate)
    {
        $this->factoryToDecorate = $factoryToDecorate;

		require_once(dirname(__FILE__) . '/PreReservationExample.config.php');

		Configuration::Instance()->Register(
					dirname(__FILE__) . '/PreReservationExample.config.php',
					'PreReservationExample');
    }

    public function CreatePreAddService(UserSession $userSession)
    {
        $base = $this->factoryToDecorate->CreatePreAddService($userSession);
        return new PreReservationExampleValidation($base);
    }

    public function CreatePreUpdateService(UserSession $userSession)
    {
        $base =  $this->factoryToDecorate->CreatePreUpdateService($userSession);
        return new PreReservationExampleValidation($base);
    }

    public function CreatePreDeleteService(UserSession $userSession)
    {
        return $this->factoryToDecorate->CreatePreDeleteService($userSession);
    }

    /**
     * @param UserSession $userSession
     * @return IReservationValidationService
     */
    public function CreatePreApprovalService(UserSession $userSession)
    {
        return $this->factoryToDecorate->CreatePreApprovalService($userSession);
    }

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreCheckinService(UserSession $userSession)
	{
		return $this->factoryToDecorate->CreatePreCheckinService($userSession);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreCheckoutService(UserSession $userSession)
	{
		return $this->factoryToDecorate->CreatePreCheckoutService($userSession);
	}
}