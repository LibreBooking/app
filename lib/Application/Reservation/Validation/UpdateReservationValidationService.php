<?php
class UpdateReservationValidationService implements IUpdateReservationValidationService
{
	/**
	 * @var IExistingReservationValidationRule[]
	 */
	private $_validationRules;
	
	/**
	 * @param IExistingReservationValidationRule[] $validationRules
	 */
	public function __construct($validationRules)
	{
		$this->_validationRules = $validationRules;	
	}
	
	/**
	 * @see IUpdateReservationValidationService::Validate()
	 */
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
}

interface IUpdateReservationValidationService
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 * @return IReservationValidationResult
	 */
	function Validate($reservationSeries);
}
?>