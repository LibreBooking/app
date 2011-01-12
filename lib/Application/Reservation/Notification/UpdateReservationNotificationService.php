<?php
class UpdateReservationNotificationService implements IUpdateReservationNotificationService
{
	public function Notify($reservationSeries)
	{
		throw new Exception('Not Implemented');
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