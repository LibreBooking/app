<?php

interface IUpdateReservationValidationService
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 * @return IReservationValidationResult
	 */
	function Validate($reservationSeries);
}

class UpdateReservationValidationService implements IUpdateReservationValidationService
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