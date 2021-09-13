<?php

class SchedulePeriodRule implements IReservationValidationRule
{
    /**
     * @var IScheduleRepository
     */
    private $repository;

    /**
     * @var UserSession
     */
    private $session;

    public function __construct(IScheduleRepository $repository, UserSession $session)
    {
        $this->repository = $repository;
        $this->session = $session;
    }

    /**
     * @param ReservationSeries $reservationSeries
     * @param $retryParameters
     * @return ReservationRuleResult
     * @throws Exception
     */
    public function Validate($reservationSeries, $retryParameters)
    {
        if (!$reservationSeries->CurrentInstance()->WereDatesChanged()) {
            return new ReservationRuleResult();
        }

        $layout = $this->repository->GetLayout($reservationSeries->Resource()->GetScheduleId(), new ScheduleLayoutFactory($this->session->Timezone));

        $startDate = $reservationSeries->CurrentInstance()->StartDate();
        $startPeriod = $layout->GetPeriod($startDate);
        $endDate = $reservationSeries->CurrentInstance()->EndDate();
        $endPeriod = $layout->GetPeriod($endDate);

        $errors = new StringBuilder();
        if ($startPeriod == null || !$startPeriod->IsReservable() || !$startPeriod->BeginDate()->Equals($startDate)) {
            $errors->AppendLine(Resources::GetInstance()->GetString('InvalidStartSlot'));
        }

        if ($endPeriod == null || !$endPeriod->BeginDate()->Equals($endDate)) {
            $errors->AppendLine(Resources::GetInstance()->GetString('InvalidEndSlot'));
        }

        $errorMessage = $errors->ToString();

        return new ReservationRuleResult(strlen($errorMessage) == 0, $errorMessage);
    }
}
