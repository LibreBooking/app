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
//			//length, (quota?)
//			//$rules[] = new QuotaRule();
//			//$rules[] = new AccessoryAvailabilityRule();
		}
	}
	
	private function GetCreate(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationRepository();
		$resourceRepository = new ResourceRepository();
		
		$ruleProcessor->AddRule(new ResourceAvailabilityRule($reservationRepository, $userSession->Timezone));
		$ruleProcessor->AddRule(new ResourceMinimumNoticeRule($resourceRepository));
		$ruleProcessor->AddRule(new ResourceMaximumNoticeRule($resourceRepository));
		
		return new AddReservationValidationService($ruleProcessor);
	}
	
	private function GetUpdate(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationRepository();
		$ruleProcessor->AddRule(new ExistingResourceAvailabilityRule($reservationRepository, $userSession->Timezone));
		$ruleProcessor->AddRule(new ResourceMinimumNoticeRule($resourceRepository));
		$ruleProcessor->AddRule(new ResourceMaximumNoticeRule($resourceRepository));
		
		return new UpdateReservationValidationService($ruleProcessor);
	}
	
	private function GetDelete(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		return new DeleteReservationValidationService($ruleProcessor);
	}
	
	private function GetRuleProcessor(UserSession $userSession)
	{
		// Common rules
		$rules = array();
		$rules[] = new ReservationDateTimeRule();
		$rules[] = new PermissionValidationRule(new PermissionServiceFactory(), $userSession);
		
		return new ReservationValidationRuleProcessor($rules);
	}
}
?>