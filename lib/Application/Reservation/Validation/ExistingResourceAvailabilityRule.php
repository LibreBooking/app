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
	
	protected function IsInConflict(Reservation $instance, ExistingReservationSeries $series, IReservedItemView $existingItem)
	{
		if ($existingItem->GetId() == $instance->ReservationId() ||
			$series->IsMarkedForDelete($existingItem->GetId()) ||
			$series->IsMarkedForUpdate($existingItem->GetId())
		)
		{
			return false;
		}
		
		return ($existingItem->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($existingItem->GetResourceId(), $series->AllResourceIds()));
	}
}
?>