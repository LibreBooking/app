<?php

class AddReservationValidationService implements IReservationValidationService
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

    public function Validate($reservationSeries, $retryParameters = null)
    {
        return $this->ruleProcessor->Validate($reservationSeries, $retryParameters);
    }
}
