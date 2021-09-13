<?php

class ResourceCrossDayRule implements IReservationValidationRule
{
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    public function __construct(IScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function Validate($reservationSeries, $retryParameters)
    {
        foreach ($reservationSeries->AllResources() as $resource) {
            if (!$resource->GetAllowMultiday()) {
                $schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
                $tz = $schedule->GetTimezone();
                $isSameDay = $reservationSeries->CurrentInstance()->StartDate()->ToTimezone($tz)->DateEquals($reservationSeries->CurrentInstance()->EndDate()->ToTimezone($tz));

                return new ReservationRuleResult($isSameDay, Resources::GetInstance()->GetString('MultiDayRule', $resource->GetName()));
            }
        }

        return new ReservationRuleResult();
    }
}
