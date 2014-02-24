<?php
/**
Copyright 2012-2014 Nick Korbel

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

class CustomAttributeValidationRule implements IReservationValidationRule
{
	public function __construct(IAttributeRepository $attributeRepository)
	{
		$this->attributeRepository = $attributeRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$resources = Resources::GetInstance();
		$errorMessage = new StringBuilder();
		$isValid = true;

		$attributes = $this->attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);
		foreach ($attributes as $attribute)
		{
			$value = $reservationSeries->GetAttributeValue($attribute->Id());
			$label = $attribute->Label();

			if (!$attribute->SatisfiesRequired($value))
			{
				$isValid = false;
				$errorMessage->AppendLine($resources->GetString('CustomAttributeRequired', $label));
			}

			if (!$attribute->SatisfiesConstraint($value))
			{
				$isValid = false;
				$errorMessage->AppendLine($resources->GetString('CustomAttributeInvalid', $label));
			}
		}

		if (!$isValid)
		{
			$errorMessage->PrependLine($resources->GetString('CustomAttributeErrors'));
		}

		return new ReservationRuleResult($isValid, $errorMessage->ToString());
	}
}