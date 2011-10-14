<?php

class DeleteReservationValidationService implements IReservationValidationService
{
	/**
	 * @var IReservationValidationService
	 */
	private $ruleProcessor;
	
	/**
	 * @param IReservationValidationService $ruleProcessor
	 */
	public function __construct($ruleProcessor)
	{
		$this->ruleProcessor = $ruleProcessor;	
	}
	
	public function Validate($reservationSeries)
	{
		return $this->ruleProcessor->Validate($reservationSeries);
	}
}
?>