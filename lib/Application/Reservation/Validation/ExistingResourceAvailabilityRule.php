<?php
class ExistingResourceAvailabilityRule extends ResourceAvailabilityRule implements IUpdateReservationValidationRule
{
	/**
	 * @param ReservationSeries $series
	 * @return ReservationRuleResult
	 */
	public function Validate($series)
	{
		return parent::Validate($series);
	}
	
	protected function IsInConflict(Reservation $instance, ExistingReservationSeries $series, ReservationItemView $existingReservation)
	{
		if ($existingReservation->GetReservationId() == $instance->ReservationId() ||
			$series->IsMarkedForDelete($existingReservation->GetReservationId()) ||
			$series->IsMarkedForUpdate($existingReservation->GetReservationId())
		)
		{
			return false;
		}
		
		return ($existingReservation->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($existingReservation->GetResourceId(), $series->AllResourceIds()));
	}
}
?>