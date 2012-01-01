<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/


class ReservationListing implements IMutableReservationListing
{
	/**
	 * @var array|ReservationItemView[]
	 */
	private $_reservations = array();
	
	/**
	 * @var array|ReservationItemView[]
	 */
	private $_reservationByResource = array();

	public function Add($reservation)
	{
		$this->AddItem(new ReservationListItem($reservation));
	}

	public function AddBlackout($blackout)
	{
		$this->AddItem(new BlackoutListItem($blackout));
	}

	protected function AddItem(ReservationListItem $item)
	{
		$this->_reservations[] = $item;
		$this->_reservationByResource[$item->ResourceId()][] = $item;
	}
	
	public function Count()
	{
		return count($this->_reservations);
	}
	
	public function Reservations()
	{
		return $this->_reservations;
	}
	
	public function OnDate($date)
	{
		$reservationListing = new ReservationListing();
		
		/** @var ReservationListItem $reservation  */
		foreach ($this->_reservations as $reservation)
		{
			if ($reservation->OccursOn($date))
			{
				$reservationListing->AddItem($reservation);
			}
		}
		
		return $reservationListing;
	}
	
	public function ForResource($resourceId)
	{
		$reservationListing = new ReservationListing();
		
		if (array_key_exists($resourceId, $this->_reservationByResource))
		{
			$reservationListing->_reservations = $this->_reservationByResource[$resourceId];
		}
		
		return $reservationListing;
	}
}

?>