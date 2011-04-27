<?php
class AdminExcludedRule implements IReservationValidationRule
{
	/**
	 * @var IReservationValidationRule
	 */
	private $rule;
	
	/**
	 * @var UserSession
	 */
	private $userSession;
	
	public function __construct(IReservationValidationRule $baseRule, UserSession $userSession)
	{
		$this->rule = $baseRule;
		$tihs->userSession = $userSession;	
	}
	
	public function Validate($reservationSeries)
	{
		if ($this->userSession->IsAdmin)
		{
			return new ReservationRuleResult(true);
		}
		
		return $this->rule->Validate($reservationSeries);
	}
}
?>