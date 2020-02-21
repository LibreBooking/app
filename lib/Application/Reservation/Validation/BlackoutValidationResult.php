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


class BlackoutValidationResult implements IBlackoutValidationResult
{
	/**
	 * @var array|BlackoutItemView[]
	 */
	private $conflictingBlackouts;

	/**
	 * @var array|ReservationItemView[]
	 */
	private $conflictingReservations;

	/**
	 * @param array|BlackoutItemView[] $conflictingBlackouts
	 * @param array|ReservationItemView[] $conflictingReservations
	 */
	public function __construct($conflictingBlackouts, $conflictingReservations)
	{
		$this->conflictingBlackouts = $conflictingBlackouts;
		$this->conflictingReservations = $conflictingReservations;
	}

	public function WasSuccessful()
	{
		return $this->CanBeSaved();
	}

	/**
	 * @return bool
	 */
	public function CanBeSaved()
	{
		return empty($this->conflictingBlackouts) && empty($this->conflictingReservations);
	}

	public function Message()
	{
		return null;
	}

	/**
	 * @return array|ReservationItemView[]
	 */
	public function ConflictingReservations()
	{
		return $this->conflictingReservations;
	}

	/**
	 * @return array|BlackoutItemView[]
	 */
	public function ConflictingBlackouts()
	{
		return $this->conflictingBlackouts;
	}
}
