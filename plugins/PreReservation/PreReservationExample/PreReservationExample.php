<?php
/**
Copyright 2012 Nick Korbel

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

class PreReservationRuleExample implements IReservationValidationService
{
    /**
     * @var IReservationValidationService
     */
    private $serviceToDecorate;

    public function __construct(IReservationValidationService $serviceToDecorate)
    {
        $this->serviceToDecorate = $serviceToDecorate;
    }

    /**
     * @param ReservationSeries|ExistingReservationSeries $series
     * @return IReservationValidationResult
     */
    public function Validate($series)
    {
        $result = $this->serviceToDecorate->Validate($series);

        // don't bother validating this rule if others have failed
        if (!$result->CanBeSaved())
        {
            return $result;
        }

        if ($this->PassesCustomRule($series))
        {
            return new ReservationValidationResult();
        }

        return new ReservationValidationResult(false, "Custom validation failed");
    }

    /**
     * @param ReservationSeries $series
     * @return bool
     */
    private function PassesCustomRule($series)
    {
        // make your custom checks here
        return true;
    }
}
class PreReservationExample extends PreReservationFactory
{
    /**
     * @var PreReservationFactory
     */
    private $factoryToDecorate;

    public function __construct(PreReservationFactory $factoryToDecorate)
    {
        $this->factoryToDecorate = $factoryToDecorate;
    }

    public function CreatePreAddService(UserSession $userSession)
    {
        $base = $this->factoryToDecorate->CreatePreAddService($userSession);
        return new PreReservationRuleExample($base);
    }

    public function CreatePreUpdateService(UserSession $userSession)
    {
        $base =  $this->factoryToDecorate->CreatePreUpdateService($userSession);
        return new PreReservationRuleExample($base);
    }

    public function CreatePreDeleteService(UserSession $userSession)
    {
        return $this->factoryToDecorate->CreatePreDeleteService($userSession);
    }

}

?>