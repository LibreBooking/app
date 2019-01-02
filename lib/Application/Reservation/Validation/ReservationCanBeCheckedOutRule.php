<?php

/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
class ReservationCanBeCheckedOutRule implements IReservationValidationRule
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 * @param null|ReservationRetryParameter[] $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$isOk = true;
		$atLeastOneReservationRequiresCheckIn = false;
		$tooEarly = Date::Now()->LessThan($reservationSeries->CurrentInstance()->StartDate());

		foreach ($reservationSeries->AllResources() as $resource)
		{
			if ($resource->IsCheckInEnabled())
			{
				$atLeastOneReservationRequiresCheckIn = true;
			}

			if ($tooEarly || !$reservationSeries->CurrentInstance()->IsCheckedIn())
			{
				$isOk = false;
				break;
			}
		}

		return new ReservationRuleResult($isOk && $atLeastOneReservationRequiresCheckIn, Resources::GetInstance()->GetString('ReservationCannotBeCheckedOutFrom'));
	}
}