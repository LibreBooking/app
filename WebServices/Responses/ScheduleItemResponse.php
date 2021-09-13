<?php

class ScheduleItemResponse extends RestResponse
{
    public $daysVisible;
    public $id;
    public $isDefault;
    public $name;
    public $timezone;
    public $weekdayStart;
    public $availabilityBegin;
    public $availabilityEnd;
    public $maxResourcesPerReservation;
    public $totalConcurrentReservationsAllowed;

    public function __construct(IRestServer $server, Schedule $schedule)
    {
        $this->daysVisible = $schedule->GetDaysVisible();
        $this->id = $schedule->GetId();
        $this->isDefault = $schedule->GetIsDefault();
        $this->name = $schedule->GetName();
        $this->timezone = $schedule->GetTimezone();
        $this->weekdayStart = $schedule->GetWeekdayStart();
        $this->availabilityBegin = $schedule->GetAvailabilityBegin()->ToIso();
        $this->availabilityEnd = $schedule->GetAvailabilityBegin()->ToIso();
        $this->maxResourcesPerReservation = $schedule->GetMaxResourcesPerReservation();
        $this->totalConcurrentReservationsAllowed = $schedule->GetTotalConcurrentReservations();

        $this->AddService($server, WebServices::GetSchedule, [WebServiceParams::ScheduleId => $schedule->GetId()]);
    }

    public static function Example()
    {
        return new ExampleScheduleItemResponse();
    }
}

class ExampleScheduleItemResponse extends ScheduleItemResponse
{
    public function __construct()
    {
        $this->daysVisible = 5;
        $this->id = 123;
        $this->isDefault = true;
        $this->name = 'schedule name';
        $this->timezone = 'timezone_name';
        $this->weekdayStart = 0;
        $this->availabilityBegin = Date::Now()->ToIso();
        $this->availabilityEnd = Date::Now()->AddDays(20)->ToIso();
        $this->maxResourcesPerReservation = 10;
        $this->totalConcurrentReservationsAllowed = 0;
    }
}
