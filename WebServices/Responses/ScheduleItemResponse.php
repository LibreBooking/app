<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

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

		$this->AddService($server, WebServices::GetSchedule, array(WebServiceParams::ScheduleId => $schedule->GetId()));
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

