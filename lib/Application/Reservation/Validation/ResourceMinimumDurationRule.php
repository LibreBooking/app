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

class ResourceMinimumDurationRule implements IReservationValidationRule
{
	/**
	 * @see IReservationValidationRule::Validate()
	 *
	 * @param ReservationSeries $reservationSeries
	 * @param null|ReservationRetryParameter[] $retryParameters
	 * @return ReservationRuleResult
	 * @throws Exception
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$r = Resources::GetInstance();

		$resources = $reservationSeries->AllResources();

		foreach ($resources as $resource)
		{
			if ($resource->HasMinLength())
			{
				$minDuration = $resource->GetMinLength()->Interval();
				$start = $reservationSeries->CurrentInstance()->StartDate();
				$end = $reservationSeries->CurrentInstance()->EndDate();

				$minEnd = $start->ApplyDifference($minDuration);
				if ($end->LessThan($minEnd))
				{
					return new ReservationRuleResult(false,
						$r->GetString("MinDurationError", $minDuration));
				}
			}
		}

		return new ReservationRuleResult();
	}
}