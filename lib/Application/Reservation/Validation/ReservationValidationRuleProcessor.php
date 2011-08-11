<?php
class ReservationValidationRuleProcessor implements IReservationValidationService
{
	/**
	 * @var array|IReservationValidationRule[]
	 */
	private $_validationRules = array();
	
	public function __construct($validationRules)
	{
		$this->_validationRules = $validationRules;	
	}
	
	public function Validate($reservationSeries)
	{
		/** @var $rule IReservationValidationRule */
		foreach ($this->_validationRules as $rule)
		{
			$result = $rule->Validate($reservationSeries);
			Log::Debug("Validating rule %s. Passed?: %s", get_class($rule), $result->IsValid());

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