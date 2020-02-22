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

class ExistingResourceAvailabilityRule extends ResourceAvailabilityRule implements IUpdateReservationValidationRule
{
	/**
	 * @param ReservationSeries|ExistingReservationSeries $reservationSeries
	 * @param null|ReservationRetryParameter[] $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters = null)
	{
		return parent::Validate($reservationSeries, $retryParameters);
	}

	/**
	 * @param Reservation $instance
	 * @param ReservationSeries $series
	 * @param IReservedItemView $existingItem
	 * @param BookableResource[] $keyedResources
	 * @return bool
	 */
	protected function IsInConflict(Reservation $instance, ReservationSeries $series, IReservedItemView $existingItem, $keyedResources)
	{
		// this class used to add logic, but that has been moved to the ReservationConflictIdentifier
		return parent::IsInConflict($instance, $series, $existingItem, $keyedResources);
	}
}