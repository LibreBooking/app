<?php

/**
 * Copyright 2011-2014 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
class CustomAttributeValidationRule implements IReservationValidationRule
{
	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IAttributeService $attributeService, IUserRepository $userRepository)
	{
		$this->attributeService = $attributeService;
		$this->userRepository = $userRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$resources = Resources::GetInstance();
		$errorMessage = new StringBuilder();

		$user = $this->userRepository->LoadById($reservationSeries->UserId());
		$bookedBy = $this->userRepository->LoadById($reservationSeries->BookedBy()->UserId);
		$isResourceAdmin = $bookedBy->IsResourceAdminForOneOf($reservationSeries->AllResources());
		$isAdminUser = $bookedBy->IsAdminFor($user) || $isResourceAdmin;

		$result = $this->attributeService->Validate(CustomAttributeCategory::RESERVATION, $reservationSeries->AttributeValues(), null, false, $isAdminUser);

		$isValid = $result->IsValid();

		if (!$isValid)
		{
			// make sure the failures are for attributes that apply to this reservation
			foreach ($result->InvalidAttributes() as $invalidAttribute)
			{
				$secondaryCategory = $invalidAttribute->Attribute->SecondaryCategory();
				$secondaryEntityId = $invalidAttribute->Attribute->SecondaryEntityId();

				if ($secondaryCategory == CustomAttributeCategory::USER && $secondaryEntityId != $reservationSeries->UserId())
				{
					// the attribute applies to a different user
					continue;
				}

				$errorMessage->Append($invalidAttribute->Error);
			}
		}

		if ($errorMessage->Count() > 0)
		{
			$errorMessage->PrependLine($resources->GetString('CustomAttributeErrors'));
		}

		return new ReservationRuleResult($errorMessage->Count() == 0, $errorMessage->ToString());
	}
}