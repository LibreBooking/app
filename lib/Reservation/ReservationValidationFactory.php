<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	public function Create($reservationAction)
	{
		$rules = array(
			new PermissionValidationRule(new PermissionServiceFactory()),
			new ResourceAvailabilityRule(),
		);
		//$rules[] = new QuotaRule();
		//$rules[] = new AccessoryAvailabilityRule();
		
		return new AddReservationValidationService($rules);
	}
}
?>