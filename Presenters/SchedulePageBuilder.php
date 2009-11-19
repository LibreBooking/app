<?php

interface ISchedulePageBuilder
{
	/**
	 * @param ISchedulePage $page
	 * @param array[int]ISchedule $schedules
	 * @param int $activeScheduleId
	 */
	public function BindSchedules(ISchedulePage $page, $schedules, $activeScheduleId);
	
	/**
	 * @param ISchedulePage $page
	 * @param array[int]ISchedule $schedules
	 * @return ISchedule
	 */
	public function GetCurrentSchedule(ISchedulePage $page, $schedules);
	
	/**
	 * Returns range of dates to bind in UTC
	 * @param UserSession $userSession
	 * @param ISchedule $schedule
	 * @param ISchedulePage $page
	 * @return DateRange
	 */
	public function GetScheduleDates(UserSession $userSession, ISchedule $schedule, ISchedulePage $page);
	
	/**
	 * @param ISchedulePage $page
	 * @param DateRange $dateRange display dates in UTC
	 * @param UserSession $user
	 */
	public function BindDisplayDates(ISchedulePage $page, DateRange $dateRange, UserSession $userSession);
	
	/**
	 * @param ISchedulePage $page
	 * @param array[int]ResourceDto $resources
	 * @param IDailyLayout $dailyLayout
	 */
	public function BindReservations(ISchedulePage $page, $resources, IDailyLayout $dailyLayout);
	
	/**
	 * @param ISchedulePage $page
	 * @param IScheduleLayout $layout
	 */
	public function BindLayout(ISchedulePage $page, IScheduleLayout $layout);
}

class SchedulePageBuilder implements ISchedulePageBuilder
{
	public function BindSchedules(ISchedulePage $page, $schedules, $activeScheduleId)
	{
		$page->SetSchedules($schedules);
		$page->SetScheduleId($activeScheduleId);
	}
	
	public function GetCurrentSchedule(ISchedulePage $page, $schedules)
	{
		if ($page->IsPostBack())
		{
			$schedule = $this->GetSchedule($schedules, $page->GetScheduleId());
		}
		else
		{
			$schedule = $this->GetDefaultSchedule($schedules);
		}
		
		return $schedule;
	}
	
	public function GetScheduleDates(UserSession $user, ISchedule $schedule, ISchedulePage $page)
	{
		$userTimezone = $user->Timezone;
		$selectedDate = $page->GetSelectedDate();
		$date = empty($selectedDate) ? Date::Now() : new Date($selectedDate, 'UTC');
		$currentDate = $date->ToTimezone($userTimezone)->GetDate();
		$currentWeekDay = $currentDate->Weekday();
		$scheduleLength = $schedule->GetDaysVisible();
		
		$startDay = $schedule->GetWeekdayStart();
		
		/**
		 *  Examples
		 * 
		 *  if we are on 3 and we need to start on 6, we need to go back 4 days
		 *  if we are on 3 and we need to start on 5, we need to go back 5 days
		 *  if we are on 3 and we need to start on 4, we need to go back 6 days
		 *  if we are on 3 and we need to start on 3, we need to go back 0 days
		 *  if we are on 3 and we need to start on 2, we need to go back 1 days
		 *  if we are on 3 and we need to start on 1, we need to go back 2 days
		 *  if we are on 3 and we need to start on 0, we need to go back 3 days
		 */	
		
		$adjustedDays = ($startDay - $currentWeekDay);
		
		if ($currentWeekDay < $startDay)
		{
			$adjustedDays = $adjustedDays - 7;
		}
		
		$startDate = $currentDate->AddDays($adjustedDays);
		
		return new DateRange($startDate->ToUtc(), $startDate->AddDays($scheduleLength)->ToUtc());
	}
	
	public function BindDisplayDates(ISchedulePage $page, DateRange $dateRange, UserSession $userSession)
	{
		$page->SetDisplayDates($dateRange->ToTimezone($userSession->Timezone));
	}
	
	public function BindReservations(ISchedulePage $page, $resources, IDailyLayout $dailyLayout)
	{
		$page->SetResources($resources);
		$page->SetDailyLayout($dailyLayout);
	}
	
	public function BindLayout(ISchedulePage $page, IScheduleLayout $layout)
	{
		$page->SetLayout($layout->GetLayout());
	}
	
	/**
	 * @param array[int]Schedule $schedules
	 * @return Schedule
	 */
	private function GetDefaultSchedule($schedules)
	{
		foreach ($schedules as $schedule)
		{
			if ($schedule->GetIsDefault())
			{
				return $schedule;
			}
		}
	}
		
	/**
	 * @param array[int]Schedule $schedules
	 * @param int $scheduleId
	 * @return Schedule
	 */
	private function GetSchedule($schedules, $scheduleId)
	{
		foreach ($schedules as $schedule)
		{
			/** @var $schedule Schedule */
			if ($schedule->GetId() == $scheduleId)
			{
				return $schedule;
			}
		}
	}
}
?>