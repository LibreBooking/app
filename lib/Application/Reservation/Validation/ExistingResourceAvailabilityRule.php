<?php
class ExistingResourceAvailabilityRule extends ResourceAvailabilityRule implements IUpdateReservationValidationRule
{
	/**
	 * @see IUpdateReservationValidationRule::Validate()
	 */
	public function Validate($series)
	{
		return parent::Validate($series);
	}
	
	protected function IsInConflict(Reservation $instance, ExistingReservationSeries $series, ScheduleReservation $scheduleReservation)
	{
		if ($scheduleReservation->GetReservationId() == $instance->ReservationId() ||
			$series->IsMarkedForDelete($scheduleReservation->GetReservationId()) ||
			$series->IsMarkedForUpdate($scheduleReservation->GetReservationId())
			)		
		{
			return false;
		}
		
		return ($scheduleReservation->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($scheduleReservation->GetResourceId(), $series->Resources()));
	}
}
?>