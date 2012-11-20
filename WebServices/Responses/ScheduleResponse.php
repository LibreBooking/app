<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class ScheduleResponse extends RestResponse
{
	public $daysVisible;
	public $id;
	public $isDefault;
	public $name;
	public $timezone;
	public $weekdayStart;
	public $icsUrl;
	/**
	 * @var array|SchedulePeriodResponse[]
	 */
	public $periods = array();

	public function __construct(Schedule $schedule, IScheduleLayout $layout)
	{
		$this->daysVisible = $schedule->GetDaysVisible();
		$this->id = $schedule->GetId();
		$this->isDefault = $schedule->GetIsDefault();
		$this->name = $schedule->GetName();
		$this->timezone = $schedule->GetTimezone();
		$this->weekdayStart = $schedule->GetWeekdayStart();

		if ($schedule->GetIsCalendarSubscriptionAllowed())
		{
			$url = new CalendarSubscriptionUrl(null, $schedule->GetPublicId(), null);
			$this->icsUrl = $url->__toString();
		}

		$periods = $layout->GetLayout(Date::Now());
		foreach ($periods as $period)
		{
			$this->periods[] = new SchedulePeriodResponse($period);
		}
	}

	public static function Example()
	{
		return new ExampleScheduleResponse();
	}
}

class SchedulePeriodResponse
{
	public function __construct(SchedulePeriod $schedulePeriod)
	{
		$this->start = $schedulePeriod->BeginDate()->ToIso();
		$this->end = $schedulePeriod->EndDate()->ToIso();
		$this->label = $schedulePeriod->Label();
	}

	public static function Example()
	{
		return new ExampleSchedulePeriodResponse();
	}
}

class ExampleScheduleResponse extends ScheduleResponse
{
	public function __construct()
	{
		$this->daysVisible = 5;
		$this->id = 123;
		$this->isDefault = true;
		$this->name = 'schedule name';
		$this->timezone = 'timezone_name';
		$this->weekdayStart = 0;
		$this->icsUrl = 'webcal://url/to/calendar';
		$this->periods[] = array(SchedulePeriodResponse::Example());
	}
}

class ExampleSchedulePeriodResponse extends SchedulePeriodResponse
{
	public function __construct()
	{
		$date = Date::Now()->ToIso();
		$this->start = $date;
		$this->end = $date;
		$this->label = 'label';
	}
}

?>