<?php
/**
Copyright 2013-2017 Nick Korbel

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

class DailyReservationSummary
{
	/**
	 * @var ReservationListItem
	 */
	private $_first = null;

	private $_count = 0;

	/**
	 * @var ReservationListItem[]
	 */
	private $_reservations = array();

	/**
	 * @return int
	 */
	public function NumberOfReservations()
	{
		return $this->_count;
	}

	/**
	 * @return ReservationListItem
	 */
	public function FirstReservation()
	{
		return $this->_first;
	}

	public function Reservations()
	{
		return $this->_reservations;
	}

	public function AddReservation(ReservationListItem $item)
	{
		if ($this->_first == null)
		{
			$this->_first = $item;
		}

		$this->_count++;
		$this->_reservations[] = $item;
	}
}