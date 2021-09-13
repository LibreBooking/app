<?php

class ResourceCountRule implements IReservationValidationRule
{
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @param $scheduleRepository IScheduleRepository
     */
    public function __construct($scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function Validate($reservationSeries, $retryParameters)
    {
        $schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
        $maximum = $schedule->GetMaxResourcesPerReservation();
        if (!empty($maximum)) {
            return new ReservationRuleResult(count($reservationSeries->AllResourceIds()) <= $maximum, Resources::GetInstance()->GetString('InvalidNumberOfResourcesError', [$maximum]));
        }

        return new ReservationRuleResult();
    }
}
