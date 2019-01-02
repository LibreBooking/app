<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

class ReservationDetailsFilter
{
	/**
	 * @param Date|null $reservationStart
	 * @param Date|null $reservationEnd
	 * @return bool
	 */
	public static function HideReservationDetails($reservationStart = null, $reservationEnd = null)
	{
		$hideReservationDetails = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
																		   ConfigKeys::PRIVACY_HIDE_RESERVATION_DETAILS,
																		   new LowerCaseConverter());
		if ($hideReservationDetails == 'past' && $reservationEnd != null)
		{
			return $reservationEnd->LessThan(Date::Now());
		}
		elseif ($hideReservationDetails == 'future' && $reservationEnd != null)
		{
			return $reservationEnd->GreaterThan(Date::Now());
		}
		elseif ($hideReservationDetails == 'current' && $reservationStart != null)
		{
			return $reservationStart->LessThan(Date::Now());
		}

		$converter = new BooleanConverter();
		return $converter->Convert($hideReservationDetails);
	}
}
