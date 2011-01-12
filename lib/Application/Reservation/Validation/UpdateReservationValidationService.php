<?php
class UpdateReservationValidationService implements IUpdateReservationValidationService
{
	public function Validate($reservationSeries)
	{
		throw new Exception('Not Implemented');
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