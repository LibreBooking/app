<?php
class ReservationStartTimeRule implements IReservationValidationRule
{
	/**
	 * @var UserSession
	 */
	private $userSession;
	
	public function __construct(UserSession $userSession = null)
	{
		if ($userSession != null)
		{
			$this->userSession = $userSession;
		}
		else
		{
			$this->userSession = ServiceLocator::GetServer()->GetUserSession();
		}		
	}
	
	/**
	 * @see IReservationValidationRule::Validate()
	 */
	public function Validate($reservationSeries)
	{
		if ($this->userSession->IsAdmin)
		{
			return new ReservationRuleResult();
		}
		
		$currentInstance = $reservationSeries->CurrentInstance();
		
		$startIsInFuture = $currentInstance->StartDate()->Compare(Date::Now()) >= 0;
		return new ReservationRuleResult($startIsInFuture, Resources::GetInstance()->GetString('StartIsInPast'));
	}
}
?>