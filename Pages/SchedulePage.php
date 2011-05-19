<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

class SchedulePage extends SecurePage implements ISchedulePage
{
	public function __construct()
	{
		parent::__construct('Schedule');
		
		$permissionServiceFactory = new PermissionServiceFactory();
		$scheduleRepository = new ScheduleRepository();
		$resourceService = new ResourceService(new ResourceRepository());
		$pageBuilder = new SchedulePageBuilder();
		$reservationService = new ReservationService(new ReservationRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();
		$this->_presenter = new SchedulePresenter($this, $scheduleRepository, $resourceService, $pageBuilder, $permissionServiceFactory, $reservationService, $dailyLayoutFactory);
	}
	
	public function PageLoad()
	{
		$start = microtime(true);
		
		$this->_presenter->PageLoad();
		
		$endLoad = microtime(true);
		
		$this->smarty->display('schedule.tpl');		
		
		$endDisplay = microtime(true);
		
		$load = $endLoad-$start;
		$display = $endDisplay-$endLoad;
		//echo ("load: $load display: $display");
	}
	
	public function IsPostBack()
	{
		// TODO: Is this method needed?
		return !is_null($this->GetScheduleId());
	}
	
	public function GetScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function SetScheduleId($scheduleId)
	{
		$this->smarty->assign('ScheduleId', $scheduleId);
	}
	
	public function SetScheduleName($scheduleName)
	{
		$this->smarty->assign('ScheduleName', $scheduleName);
	}
	
	public function SetSchedules($schedules)
	{
		$this->smarty->assign('Schedules', $schedules);
	}
	
	/**
	 * @see ISchedulePage:SetFirstWeekday()
	 */
	function SetFirstWeekday($firstWeekday)
	{
		$this->smarty->assign('FirstWeekday', $firstWeekday);
	}
	
	public function SetResources($resources)
	{
		$this->smarty->assign('Resources', $resources);
	}
	
	public function SetDailyLayout($dailyLayout)
	{
		$this->smarty->assign('DailyLayout', $dailyLayout);
	}
	
	public function SetLayout($schedulePeriods)
	{
		$this->smarty->assign('Periods', $schedulePeriods);
	}
	
	/**
	 * @see ISchedulePage:SetDisplayDates()
	 */
	public function SetDisplayDates($dateRange)
	{
		$this->smarty->assign('DisplayDates', $dateRange);
		$this->smarty->assign('BoundDates', $dateRange->Dates());
	}
	
	public function SetPreviousNextDates($previousDate, $nextDate)
	{
		$this->smarty->assign('PreviousDate', $previousDate);
		$this->smarty->assign('NextDate', $nextDate);
	}
	
	public function GetSelectedDate()
	{
		// TODO: Clean date
		return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
	}
}

interface ISchedulePage
{
	/**
	 * Bind schedules to the page
	 *
	 * @param array[int]Schedule $schedules
	 */
	public function SetSchedules($schedules);
	
	/**
	 * Bind resources to the page
	 *
	 * @param array[int]ResourceDto $resources
	 */
	public function SetResources($resources);
	
	/**
	 * Bind layout to the page for daily time slot layouts
	 *
	 * @param IDailyLayout $dailyLayout
	 */
	public function SetDailyLayout($dailyLayout);
	
	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param array[int]ISchedulePeriod
	 */
	public function SetLayout($schedulePeriods);
	
	/**
	 * Returns the currently selected scheduleId
	 * @return int
	 */
	public function GetScheduleId();
	
	/**
	 * @param int $scheduleId
	 */
	public function SetScheduleId($scheduleId);
	
	/**
	 * @param string $scheduleName
	 */
	public function SetScheduleName($scheduleName);
	
	/**
	 * @param int $firstWeekday
	 */
	public function SetFirstWeekday($firstWeekday);
	
	/**
	 * Sets the dates to be displayed for the schedule, adjusted for timezone if necessary
	 *
	 * @param DateRange $dates
	 */
	public function SetDisplayDates($dates);
	
	/**
	 * @param Date $previousDate
	 * @param Date $nextDate
	 */
	public function SetPreviousNextDates($previousDate, $nextDate);
	
	/**
	 * @return bool
	 */
	public function IsPostBack();
	
	/**
	 * @return string
	 */
	public function GetSelectedDate();
}
?>