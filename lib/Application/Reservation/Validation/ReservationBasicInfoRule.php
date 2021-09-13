<?php

class ReservationBasicInfoRule implements IReservationValidationRule
{
    public function Validate($reservationSeries, $retryParameters)
    {
        $userId = $reservationSeries->UserId();
        $resourceId = $reservationSeries->ResourceId();

        $isOk = !empty($userId) && !empty($resourceId);

        return new ReservationRuleResult($isOk, Resources::GetInstance()->GetString('InvalidReservationData'));
    }
}
