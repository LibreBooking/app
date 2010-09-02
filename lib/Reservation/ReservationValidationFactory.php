<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	public function Create($reservationAction)
	{
		$rules = array();
		$rules[] = new PermissionValidationRule(new PermissionServiceFactory());
		
		return new AddReservationValidationService($rules);
	}
}
?>