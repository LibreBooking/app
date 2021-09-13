<?php

class Report_GroupBy
{
    public const NONE = 'NONE';
    public const RESOURCE = 'RESOURCE';
    public const SCHEDULE = 'SCHEDULE';
    public const USER = 'USER';
    public const GROUP = 'GROUP';

    /**
     * @var Report_GroupBy|string
     */
    private $groupBy;

    /**
     * @param $groupBy string|Report_GroupBy
     */
    public function __construct($groupBy)
    {
        $this->groupBy = $groupBy;
    }

    public function Add(ReportCommandBuilder $builder)
    {
        if ($this->groupBy == self::GROUP) {
            $builder->GroupByGroup();
        }
        if ($this->groupBy == self::SCHEDULE) {
            $builder->GroupBySchedule();
        }
        if ($this->groupBy == self::USER) {
            $builder->GroupByUser();
        }
        if ($this->groupBy == self::RESOURCE) {
            $builder->GroupByResource();
        }
    }

    public function __toString()
    {
        return $this->groupBy;
    }
}
