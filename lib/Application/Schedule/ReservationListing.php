<?php

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