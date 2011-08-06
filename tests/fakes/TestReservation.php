<?php

class TestReservation extends Reservation
{
	/**
	 * @param string $referenceNumber
	 * @param DateRange $reservationDate
	 * @param int $reservationId
	 */
	public function __construct($referenceNumber = null, $reservationDate = null, $reservationId = null)
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

		$this->SetReservationId($reservationId);
	}

	public function WithAddedInvitees($inviteeIds)
	{
		$this->addedInvitees = $inviteeIds;
	}

	public function WithAddedParticipants($participantIds)
	{
		$this->addedParticipants = $participantIds;
	}
}
?>