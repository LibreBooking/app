<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	public function Create($reservationAction)
	{
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		$rules = array(
			new ReservationDateTimeRule(),
			new PermissionValidationRule(new PermissionServiceFactory()),
			new ResourceAvailabilityRule(new ReservationRepository(), $userSession->Timezone),
		);
		//length, start time buffer, end time buffer (quota?)
		//$rules[] = new QuotaRule();
		//$rules[] = new AccessoryAvailabilityRule();
		
		return new AddReservationValidationService($rules);
	}
}
?>