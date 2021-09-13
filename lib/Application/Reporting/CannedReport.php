<?php

interface ICannedReport
{
    /**
     * @return ReportCommandBuilder
     */
    public function GetBuilder();
}

class CannedReport implements ICannedReport
{
    public const RESOURCE_COUNT_ALLTIME = 1;
    public const RESOURCE_COUNT_THISWEEK = 2;
    public const RESOURCE_COUNT_THISMONTH = 3;
    public const RESOURCE_TIME_ALLTIME = 4;
    public const RESOURCE_TIME_THISWEEK = 5;
    public const RESOURCE_TIME_THISMONTH = 6;
    public const USER_TIME_ALLTIME = 7;
    public const USER_TIME_THISWEEK = 8;
    public const USER_TIME_THISMONTH = 9;
    public const USER_COUNT_ALLTIME = 10;
    public const USER_COUNT_THISWEEK = 11;
    public const USER_COUNT_THISMONTH = 12;
    public const RESERVATIONS_TODAY = 13;
    public const RESERVATIONS_THISWEEK = 14;
    public const RESERVATIONS_THISMONTH = 15;
    public const ACCESSORIES_TODAY = 16;
    public const ACCESSORIES_THISWEEK = 17;
    public const ACCESSORIES_THISMONTH = 18;

    public const LIMIT = 20;

    /**
     * @var array
     */
    private static $mapping = [
        self::RESOURCE_COUNT_ALLTIME => 'ResourceCountAllTime',
        self::RESOURCE_COUNT_THISWEEK => 'ResourceCountThisWeek',
        self::RESOURCE_COUNT_THISMONTH => 'ResourceCountThisMonth',
        self::RESOURCE_TIME_ALLTIME => 'ResourceTimeAllTime',
        self::RESOURCE_TIME_THISWEEK => 'ResourceTimeThisWeek',
        self::RESOURCE_TIME_THISMONTH => 'ResourceTimeThisMonth',
        self::USER_TIME_ALLTIME => 'UserTimeAllTime',
        self::USER_TIME_THISWEEK => 'UserTimeThisWeek',
        self::USER_TIME_THISMONTH => 'UserTimeThisMonth',
        self::USER_COUNT_ALLTIME => 'UserCountAllTime',
        self::USER_COUNT_THISWEEK => 'UserCountThisWeek',
        self::USER_COUNT_THISMONTH => 'UserCountThisMonth',
        self::RESERVATIONS_TODAY => 'ReservationsToday',
        self::RESERVATIONS_THISWEEK => 'ReservationsThisWeek',
        self::RESERVATIONS_THISMONTH => 'ReservationsThisMonth',
        self::ACCESSORIES_TODAY => 'AccessoriesToday',
        self::ACCESSORIES_THISWEEK => 'AccessoriesThisWeek',
        self::ACCESSORIES_THISMONTH => 'AccessoriesThisMonth',
    ];

    /**
     * @var UserSession
     */
    private $user;

    /**
     * @var string
     */
    private $method;

    /**
     * @var Report_Range
     */
    private $todayRange;

    /**
     * @var Report_Range
     */
    private $weekRange;

    /**
     * @var Report_Range
     */
    private $monthRange;

    public function __construct($type, UserSession $userSession)
    {
        $this->user = $userSession;

        if (array_key_exists($type, self::$mapping)) {
            $this->method = self::$mapping[$type];
        } else {
            throw new Exception("Unknown canned report: $type");
        }

        $this->todayRange = new Report_Range(Report_Range::TODAY, null, null, $this->user->Timezone);
        $this->weekRange = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->user->Timezone);
        $this->monthRange = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->user->Timezone);
    }

    /**
     * @return ReportCommandBuilder
     */
    public function GetBuilder()
    {
        $methodName = $this->method;
        return $this->$methodName();
    }

    private function LimitToToday(ReportCommandBuilder $builder)
    {
        $builder->Within($this->todayRange->Start(), $this->todayRange->End());
        return $builder;
    }

    private function LimitToWeek(ReportCommandBuilder $builder)
    {
        $builder->Within($this->weekRange->Start(), $this->weekRange->End());
        return $builder;
    }

    private function LimitToMonth(ReportCommandBuilder $builder)
    {
        $builder->Within($this->monthRange->Start(), $this->monthRange->End());
        return $builder;
    }

    private function ResourceCountAllTime()
    {
        $builder = new ReportCommandBuilder();
        $builder->SelectCount()
                ->OfResources()
                ->GroupByResource();

        return $builder;
    }

    private function ResourceCountThisWeek()
    {
        return $this->LimitToWeek($this->ResourceCountAllTime());
    }

    private function ResourceCountThisMonth()
    {
        return $this->LimitToMonth($this->ResourceCountAllTime());
    }

    private function ResourceTimeAllTime()
    {
        $builder = new ReportCommandBuilder();
        $builder->SelectTime()
                ->OfResources()
                ->GroupByResource();

        return $builder;
    }

    private function ResourceTimeThisWeek()
    {
        return $this->LimitToWeek($this->ResourceTimeAllTime());
    }

    private function ResourceTimeThisMonth()
    {
        return $this->LimitToMonth($this->ResourceTimeAllTime());
    }

    private function UserTimeAllTime()
    {
        $builder = new ReportCommandBuilder();
        $builder->SelectTime()
                ->OfResources()
                ->GroupByUser()
                ->LimitedTo(self::LIMIT);

        return $builder;
    }

    private function UserTimeThisWeek()
    {
        return $this->LimitToWeek($this->UserTimeAllTime());
    }

    private function UserTimeThisMonth()
    {
        return $this->LimitToMonth($this->UserTimeAllTime());
    }

    private function UserCountAllTime()
    {
        $builder = new ReportCommandBuilder();
        $builder->SelectCount()
                ->OfResources()
                ->GroupByUser()
                ->LimitedTo(self::LIMIT);

        return $builder;
    }

    private function UserCountThisWeek()
    {
        return $this->LimitToWeek($this->UserCountAllTime());
    }

    private function UserCountThisMonth()
    {
        return $this->LimitToMonth($this->UserCountAllTime());
    }

    private function ReservationsAllTime()
    {
        $builder = new ReportCommandBuilder();
        $builder->SelectFullList()
                ->OfResources();

        return $builder;
    }

    private function ReservationsToday()
    {
        return $this->LimitToToday($this->ReservationsAllTime());
    }

    private function ReservationsThisWeek()
    {
        return $this->LimitToWeek($this->ReservationsAllTime());
    }

    private function ReservationsThisMonth()
    {
        return $this->LimitToMonth($this->ReservationsAllTime());
    }

    private function AccessoriesAllTime()
    {
        $builder = new ReportCommandBuilder();
        $builder->SelectFullList()
                ->OfAccessories();

        return $builder;
    }

    private function AccessoriesToday()
    {
        return $this->LimitToToday($this->AccessoriesAllTime());
    }

    private function AccessoriesThisWeek()
    {
        return $this->LimitToWeek($this->AccessoriesAllTime());
    }

    private function AccessoriesThisMonth()
    {
        return $this->LimitToMonth($this->AccessoriesAllTime());
    }
}
