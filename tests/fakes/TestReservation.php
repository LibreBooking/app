<?php

class TestReservation extends Reservation
{
	public function __construct($referenceNumber = null, $reservationDate = null)
	{
		if (!empty($referenceNumber))
		{
			$this->SetReferenceNumber($referenceNumber);
		}
		else
		{
			$this->SetReferenceNumber(uniqid());
		}
		
		if ($reservationDate != null)
		{
			$this->SetReservationDate($reservationDate);
		}
		else
		{
			$this->SetReservationDate(new TestDateRange());
		}
		
	}
}
?>