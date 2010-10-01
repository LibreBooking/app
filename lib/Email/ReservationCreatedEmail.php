<?php
class ReservationCreatedEmail implements IEmailMessage
{
	public function __construct(User $reservationOwner, Reservation $reservation, IResource $primaryResource)
	{
		
	}
}
?>