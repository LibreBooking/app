<?php

class TitleRequiredRule implements IReservationValidationRule
{
    public function __construct()
    {
    }

    public function Validate($reservationSeries, $retryParameters)
    {
        $title = $reservationSeries->Title();
        return new ReservationRuleResult(!empty($title), Resources::GetInstance()->GetString('TitleRequiredRule'));
    }
}
