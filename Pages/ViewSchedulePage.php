<?php
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
		$reservationService = new ReservationService(new ReservationRepository(), new ReservationListingFactory());
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
}
?>