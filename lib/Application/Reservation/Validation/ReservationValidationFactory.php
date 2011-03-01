<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	public function Create($reservationAction, $userSession)
	{
		//$userSession = ServiceLocator::GetServer()->GetUserSession();
		$dateTimeRule = new ReservationDateTimeRule();
		$permissionRule = new PermissionValidationRule(new PermissionServiceFactory(), $userSession);
		
		if ($reservationAction == ReservationAction::Update)
		{
			$rules = array(
				$dateTimeRule,
				$permissionRule,
			);
			return new UpdateReservationValidationService($rules);	
		}
		
		$rules = array(
			$dateTimeRule,
			$permissionRule,
			new ResourceAvailabilityRule(new ReservationRepository(), $userSession->Timezone),
		);
		//length, start time buffer, end time buffer (quota?)
		//$rules[] = new QuotaRule();
		//$rules[] = new AccessoryAvailabilityRule();
		
		return new AddReservationValidationService($rules);
	}
}
?>