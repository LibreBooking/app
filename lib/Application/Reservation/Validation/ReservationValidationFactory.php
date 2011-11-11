<?php
class ReservationValidationFactory implements IReservationValidationFactory
{
	/**
	 * @var array|string[]
	 */
	private $creationStrategies = array();

	public function __construct()
	{
		//$this->creationStrategies[ReservationAction::Approve] = 'CreateUpdateService';
		$this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
		$this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
		$this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
	}

	public function Create($reservationAction, $userSession)
	{
		if (array_key_exists($reservationAction, $this->creationStrategies))
		{
			$ruleProcessor = $this->GetRuleProcessor($userSession);

			$createMethod = $this->creationStrategies[$reservationAction];
			return $this->$createMethod($ruleProcessor, $userSession);
		}

		return new NullReservationValidationService();
	}
	
	private function CreateAddService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationRepository();

		$ruleProcessor->AddRule(new ResourceAvailabilityRule($reservationRepository, $userSession->Timezone));
		$ruleProcessor->AddRule(new AccessoryAvailabilityRule(new ReservationViewRepository(), new AccessoryRepository(), $userSession->Timezone));

		return new AddReservationValidationService($ruleProcessor);
	}
	
	private function CreateUpdateService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationRepository();
		$ruleProcessor->AddRule(new ExistingResourceAvailabilityRule($reservationRepository, $userSession->Timezone));

		return new UpdateReservationValidationService($ruleProcessor);
	}
	
	private function CreateDeleteService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		return new DeleteReservationValidationService($ruleProcessor);
	}
	
	private function GetRuleProcessor(UserSession $userSession)
	{
		$resourceRepository = new ResourceRepository();
		// Common rules
		$rules = array();
		$rules[] = new ReservationDateTimeRule();
		$rules[] = new AdminExcludedRule(new ReservationStartTimeRule(), $userSession);
		$rules[] = new AdminExcludedRule(new PermissionValidationRule(new PermissionServiceFactory()), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMinimumNoticeRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMaximumNoticeRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMinimumDurationRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMaximumDurationRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new QuotaRule(new QuotaRepository(), new ReservationViewRepository(), new UserRepository(), new ScheduleRepository()), $userSession);

		return new ReservationValidationRuleProcessor($rules);
	}
}

class NullReservationValidationService implements IReservationValidationService
{
	/**
	 * @param ReservationSeries $reservation
	 * @return IReservationValidationResult
	 */
	function Validate($reservation)
	{
		return new ReservationValidationResult();
	}
}
?>