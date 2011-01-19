<?php
class UpdateReservationValidationService implements IUpdateReservationValidationService
{
	public function Validate($reservationSeries)
	{
		// temporary no-op
		return new ReservationValidationResult();
		//throw new Exception('Not Implemented');
	}
}

interface IUpdateReservationValidationService
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 * @return IReservationValidationResult
	 */
	function Validate($reservationSeries);
}
?>