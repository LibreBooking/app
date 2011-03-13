<?php
class ReservationValidationRuleProcessor implements IReservationValidationService
{
	private $_validationRules = array();
	
	public function __construct($validationRules)
	{
		$this->_validationRules = $validationRules;	
	}
	
	public function Validate($reservationSeries)
	{
		foreach ($this->_validationRules as $rule)
		{
			$result = $rule->Validate($reservationSeries);
			
			if (!$result->IsValid())
			{
				return new ReservationValidationResult(false, array($result->ErrorMessage()));
			}
		}
		
		return new ReservationValidationResult();
	}
	
	public function AddRule($validationRule)
	{
		$this->_validationRules[] = $validationRule;
	}
}
?>