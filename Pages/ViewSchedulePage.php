<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/SchedulePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

class NullPermissionService implements IPermissionService
{
	/**
	 * @param IResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IResource $resource, UserSession $user)
	{
		return false;
	}
}

class ViewSchedulePage extends Page implements ISchedulePage
{
	public function __construct()
	{
		parent::__construct('Schedule');
		
		$scheduleRepository = new ScheduleRepository();
		$resourceService = new ResourceService(new ResourceRepository(), new NullPermissionService());
		$pageBuilder = new SchedulePageBuilder();
		$reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();
		
		$this->_presenter = new SchedulePresenter(
			$this,
			$scheduleRepository,
			$resourceService,
			$pageBuilder,
			$reservationService,
			$dailyLayoutFactory);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad(new NullUserSession());
		$this->Set('DisplaySlotFactory', new DisplaySlotFactory());
		$this->Display('view-schedule.tpl');
	}
	
	public function IsPostBack()
	{
		return !is_null($this->GetScheduleId());
	}
	
	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}
	
	public function SetScheduleName($scheduleName)
	{
		$this->Set('ScheduleName', $scheduleName);
	}
	
	public function SetSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}
	
	function SetFirstWeekday($firstWeekday)
	{
		$this->Set('FirstWeekday', $firstWeekday);
	}
	
	public function SetResources($resources)
	{
		$this->Set('Resources', $resources);
	}
	
	public function SetDailyLayout($dailyLayout)
	{
		$this->Set('DailyLayout', $dailyLayout);
	}
	
	public function SetLayout($schedulePeriods)
	{
		$this->Set('Periods', $schedulePeriods);
	}
	
	public function SetDisplayDates($dateRange)
	{
		$this->Set('DisplayDates', $dateRange);
		$this->Set('BoundDates', $dateRange->Dates());
	}
	
	public function SetPreviousNextDates($previousDate, $nextDate)
	{
		$this->Set('PreviousDate', $previousDate);
		$this->Set('NextDate', $nextDate);
	}
	
	public function GetSelectedDate()
	{
		// TODO: Clean date
		return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
	}

    public function ShowInaccessibleResources()
    {
        return true;
    }

	/**
	 * @param bool $showShowFullWeekToggle
	 */
	public function ShowFullWeekToggle($showShowFullWeekToggle)
	{
		$this->Set('ShowFullWeekLink', $showShowFullWeekToggle);
	}

	public function GetShowFullWeek()
	{
		$showFullWeek = $this->GetQuerystring(QueryStringKeys::SHOW_FULL_WEEK);

		return !empty($showFullWeek);
	}
}
?>