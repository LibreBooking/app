<?php
class AddReservationValidationService implements IReservationValidationService
{
	/**
	 * @var IReservationValidationRule[]
	 */
	private $_validationRules;
	
	/**
	 * @param IReservationValidationRule[] $validationRules
	 */
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
				return new ReservationValidationResult(false, array($result->ErrorMessage()));
			}
		}
		
		return new ReservationValidationResult();
	}
}
?>