<?php
/**
 * Copyright 2020 Nick Korbel
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


class FakeReservationConflictIdentifier implements IReservationConflictIdentifier
{

	/**
	 * @var ReservationConflictResult
	 */
	public $_Conflicts = null;

	/**
	 * @var ReservationConflictResult
	 */
	public $_IndexedConflicts = [];

	private $_GetConflictCall = 0;

	public function GetConflicts($reservationSeries)
	{
		if (!empty($this->_IndexedConflicts)) {
			return $this->_IndexedConflicts[$this->_GetConflictCall++];
		}
		return $this->_Conflicts;
	}
}

class FakeReservationConflictResult extends ReservationConflictResult {

	public $_AllowReservation = true;

	public function __construct($allowReservation = true)
	{
		$this->_AllowReservation = $allowReservation;
		parent::__construct([], 0, false, 1);
	}

	public function AllowReservation($numberOfConflictsSkipped = 0)
	{
		return $this->_AllowReservation;
	}
}

