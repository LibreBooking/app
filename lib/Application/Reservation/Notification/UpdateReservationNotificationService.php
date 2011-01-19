<?php
class UpdateReservationNotificationService implements IUpdateReservationNotificationService
{
	public function Notify($reservationSeries)
	{
		// temp no-op
		//throw new Exception('Not Implemented');
	}
}

interface IUpdateReservationNotificationService
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries);
}

?>