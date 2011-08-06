<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	public function Create($reservationAction, $userSession)
	{
		$ruleProcessor = $this->GetRuleProcessor($userSession);
		
		if ($reservationAction == ReservationAction::Update)
		{
			return $this->GetUpdate($ruleProcessor, $userSession);
		}
		else if ($reservationAction == ReservationAction::Delete)
		{
			return $this->GetDelete($ruleProcessor, $userSession);
		}	
		else 
		{
			return $this->GetCreate($ruleProcessor, $userSession);
//			//length
//			//$rules[] = new AccessoryAvailabilityRule();
		}
	}
	
	private function GetCreate(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationRepository();

		$ruleProcessor->AddRule(new ResourceAvailabilityRule($reservationRepository, $userSession->Timezone));
		
		return new AddReservationValidationService($ruleProcessor);
	}
	
	private function GetUpdate(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationRepository();
		$ruleProcessor->AddRule(new ExistingResourceAvailabilityRule($reservationRepository, $userSession->Timezone));

		return new UpdateReservationValidationService($ruleProcessor);
	}
	
	private function GetDelete(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		return new DeleteReservationValidationService($ruleProcessor);
	}
	
	private function GetRuleProcessor(UserSession $userSession)
	{
		$resourceRepository = new ResourceRepository();
		// Common rules
		$rules = array();
		$rules[] = new ReservationDateTimeRule();
		$rules[] = new AdminExcludedRule(new PermissionValidationRule(new PermissionServiceFactory()), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMinimumNoticeRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMaximumNoticeRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMinimumDurationRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMaximumDurationRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new QuotaRule(new QuotaRepository(), new ReservationViewRepository(), new UserRepository(), new ScheduleRepository()), $userSession);

		return new ReservationValidationRuleProcessor($rules);
	}
}
?>