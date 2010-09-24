<?php
class ReservationPersistenceFactory implements IReservationPersistenceFactory 
{
	public function Create($reservationAction)
	{
		return new AddReservationPersistenceService(new ReservationRepository());
	}
}
?>