<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	public function Create($reservationAction)
	{
		$rules = array(
			new ReservationDateTimeRule(),
			new PermissionValidationRule(new PermissionServiceFactory()),
			new ResourceAvailabilityRule(new ReservationRepository()),
		);
		//length, start time buffer, end time buffer (quota?)
		//$rules[] = new QuotaRule();
		//$rules[] = new AccessoryAvailabilityRule();
		
		return new AddReservationValidationService($rules);
	}
}
?>