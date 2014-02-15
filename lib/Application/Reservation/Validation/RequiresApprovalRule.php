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

class RequiresApprovalRule implements IReservationValidationRule
{
	/**
	 * @var IAuthorizationService
	 */
	private $authorizationService;

	public function __construct(IAuthorizationService $authorizationService)
	{
		$this->authorizationService = $authorizationService;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	function Validate($reservationSeries)
	{
		$status = ReservationStatus::Created;

		/** @var BookableResource $resource */
		foreach ($reservationSeries->AllResources() as $resource)
		{
			if ($resource->GetRequiresApproval())
			{
				if (!$this->authorizationService->CanApproveForResource($reservationSeries->BookedBy(), $resource))
				{
					$status = ReservationStatus::Pending;
					break;
				}
			}
		}

		$reservationSeries->SetStatusId($status);

		return new ReservationRuleResult();
	}
}