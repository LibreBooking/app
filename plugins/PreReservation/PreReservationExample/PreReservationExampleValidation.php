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

class PreReservationExampleValidation implements IReservationValidationService
{
	/**
	 * @var IReservationValidationService
	 */
	private $serviceToDecorate;

	public function __construct(IReservationValidationService $serviceToDecorate)
	{
		$this->serviceToDecorate = $serviceToDecorate;
	}

	public function Validate($series, $retryParameters = null)
	{
		$result = $this->serviceToDecorate->Validate($series, $retryParameters);

		// don't bother validating this rule if others have failed
		if (!$result->CanBeSaved())
		{
			return $result;
		}

		return $this->EvaluateCustomRule($series);
	}

	private function EvaluateCustomRule($series)
	{
		Log::Debug('Evaluating custom pre reservation rule');
		// make your custom checks here
		$configFile = Configuration::Instance()->File('PreReservationExample');
		$maxValue = $configFile->GetKey('custom.attribute.max.value');
		$customAttributeId = $configFile->GetKey('custom.attribute.id');

		$attributeValue = $series->GetAttributeValue($customAttributeId);

		$isValid = $attributeValue <= $maxValue;

		if ($isValid)
		{
			return new ReservationValidationResult();
		}

		return new ReservationValidationResult(false, "Value of custom attribute cannot be greater than $maxValue");
	}
}