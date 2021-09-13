<?php

class Report_ResultSelection
{
    public const COUNT = 'COUNT';
    public const TIME = 'TIME';
    public const FULL_LIST = 'LIST';
    public const UTILIZATION = 'UTILIZATION';

    /**
     * @var Report_ResultSelection|string
     */
    private $selection;

    /**
     * @param $selection string|Report_ResultSelection
     */
    public function __construct($selection)
    {
        $this->selection = $selection;
    }

    public function Add(ReportCommandBuilder $builder)
    {
        if ($this->selection == self::FULL_LIST) {
            $builder->SelectFullList();
        }
        if ($this->selection == self::COUNT) {
            $builder->SelectCount();
        }
        if ($this->selection == self::TIME) {
            $builder->SelectTime();
        }
        if ($this->selection == self::UTILIZATION) {
            $builder->SelectDuration()->IncludingBlackouts()->OfResources();
        }
    }

    /**
     * @param $selection string
     * @return bool
     */
    public function Equals($selection)
    {
        return $this->selection == $selection;
    }

    public function __toString()
    {
        return $this->selection;
    }
}
