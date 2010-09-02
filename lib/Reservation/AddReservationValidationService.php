<?php
class AddReservationValidationService implements IReservationValidationService
{
	private $_validationRules;
	
	public function __construct($validationRules)
	{
		$this->_validationRules = $validationRules;	
	}
	
	/**
	 * @see IReservationValidationService::Validate()
	 */
	public function Validate($reservation)
	{
		foreach ($this->_validationRules as $rule)
		{
			$result = $rule->Validate($reservation);
			
			if (!$result->IsValid())
			{
				return new ReservationValidResult(false, array($result->ErrorMessage()));
			}
		}
		
		return new ReservationValidResult();
	}
}
?>