<?php
class ReservationCreatedEmailAdmin implements IEmailMessage
{
	public function __construct($admins, User $reservationOwner, Reservation $reservation, IResource $primaryResource)
	{
		
	}
}
?>