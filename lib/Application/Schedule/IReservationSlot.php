<?php
/**
Copyright 2011-2014 Nick Korbel

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

interface IReservationSlot
{
	/**
	 * @return Time
	 */
	public function Begin();

	/**
	 * @return Time
	 */
	public function End();

	/**
	 * @return Date
	 */
	public function BeginDate();

	/**
	 * @return Date
	 */
	public function EndDate();

	/**
	 * @return Date
	 */
	public function Date();

	/**
	 * @return int
	 *
	 */
	public function PeriodSpan();

	/**
	 * @return string
	 */
	public function Label();

	/**
	 * @return bool
	 */
	public function IsReservable();

	/**
	 * @return bool
	 */
	public function IsReserved();

	/**
	 * @return bool
	 */
	public function IsPending();

	/**
	 * @param $date Date
	 * @return bool
	 */
	public function IsPastDate(Date $date);

	/**
	 * @param string $timezone
	 * @return IReservationSlot
	 */
	public function ToTimezone($timezone);

	/**
	 * @param UserSession $session
	 * @return bool
	 */
	public function IsOwnedBy(UserSession $session);

	/**
	 * @param UserSession $session
	 * @return bool
	 */
	public function IsParticipating(UserSession $session);

	/**
	 * @return string
	 */
	public function BeginSlotId();

	/**
	 * @return string
	 */
	public function EndSlotId();

	/**
	 * @return bool
	 */
	public function HasCustomColor();

	/**
	 * @return string
	 */
	public function Color();

	/**
	 * @return string
	 */
	public function TextColor();
}