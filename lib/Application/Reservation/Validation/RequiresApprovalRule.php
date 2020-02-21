<?php
/**
Copyright 2012-2020 Nick Korbel

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
	 * @param null|ReservationRetryParameter[] $retryParameters
	 * @return ReservationRuleResult
	 */
	function Validate($reservationSeries, $retryParameters)
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