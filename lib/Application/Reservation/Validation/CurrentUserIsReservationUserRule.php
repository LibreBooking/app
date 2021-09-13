<?php

class CurrentUserIsReservationUserRule implements IReservationValidationRule
{
    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(UserSession $userSession)
    {
        $this->userSession = $userSession;
    }

    public function Validate($reservationSeries, $retryParameters)
    {
        return new ReservationRuleResult($this->userSession->UserId == $reservationSeries->UserId(), Resources::GetInstance()->GetString('NoReservationAccess'));
    }
}
