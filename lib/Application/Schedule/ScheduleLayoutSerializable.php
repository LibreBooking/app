<?php

class ScheduleLayoutSerializable
{
    /**
     * @var array|PeriodSerializable[]
     */
    public $periods;

    /**
     * @param array|SchedulePeriod[] $periods
     */
    public function __construct($periods)
    {
        foreach ($periods as $period) {
            $this->periods[] = new PeriodSerializable($period);
        }
    }
}

class PeriodSerializable
{
    public $begin;
    public $beginDate;
    public $end;
    public $endDate;
    public $label;
    public $labelEnd;
    public $isReservable;

    public function __construct(SchedulePeriod $period)
    {
        $this->begin = $period->Begin()->__toString();
        $this->end = $period->End()->__toString();
        $this->beginDate = $period->BeginDate()->__toString();
        $this->endDate = $period->EndDate()->__toString();
        $this->isReservable = $period->IsReservable();
        $this->label = $period->Label();
        $this->labelEnd = $period->LabelEnd();
    }
}
