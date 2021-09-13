<?php

class ReservationOverlappingRule implements IReservationValidationRule
{
    /**
     * @var string
     */
    protected $timezone;

    public function __construct($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @param ReservationSeries $reservationSeries
     * @param $retryParameters
     * @return ReservationRuleResult
     * @throws Exception
     */
    public function Validate($reservationSeries, $retryParameters)
    {
        $instances = $reservationSeries->SortedInstances();
        $repeat = $reservationSeries->RepeatOptions();

        $overlap = [];
        $prev = null;
        foreach ($instances as $key => $value) {
            if (!$prev) {
                $prev = $value;
                continue;
            }

            $cur = $value;

            $end = $prev->EndDate();
            $start = $cur->StartDate();

            Log::Debug('End: %s, Start: %s', $end->ToTimezone($this->timezone), $start->ToTimezone($this->timezone));

            if ($start->DateCompare($end) < 0) {
                $overlap[] = new DateRange($end, $start);
                if ($repeat->RepeatType() == RepeatType::Daily || $repeat->RepeatType() == RepeatType::Weekly) {
                    break;
                }
            }
            $prev = $cur;
        }

        if (count($overlap) > 0) {
            return new ReservationRuleResult(
                false,
                $this->GetErrorString($overlap),
                true, // retry
                Resources::GetInstance()->GetString('RetrySkipConflicts'),
                [new ReservationRetryParameter(ReservationRetryParameter::$SKIP_CONFLICTS, true)],
                false // wait list
            );
        }

        return new ReservationRuleResult();
    }

    /**
     * @param array|DateRange[] $overlaps
     * @return string
     */
    protected function GetErrorString($overlaps)
    {
        $errorString = new StringBuilder();

        $errorString->Append(Resources::GetInstance()->GetString('InstancesOverlapRule'));
        $errorString->Append("\n");
        $format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);

        foreach ($overlaps as $conflict) {
            $errorString->Append(
                sprintf(
                    "%s > %s\n",
                    $conflict->GetBegin()->ToTimezone($this->timezone)->Format($format),
                    $conflict->GetEnd()->ToTimezone($this->timezone)->Format($format)
                )
            );
        }

        return $errorString->ToString();
    }
}
