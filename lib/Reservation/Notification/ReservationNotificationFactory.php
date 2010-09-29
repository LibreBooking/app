<?php
class ReservationNotificationFactory implements IReservationNotificationFactory
{
	public function Create($reservationAction)
	{
		return new AddReservationNotificationService();
	}
}
?>