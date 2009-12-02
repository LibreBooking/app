<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

class SchedulePage extends Page implements ISchedulePage
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
		
		$this->_presenter = new MockSchedulePresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->smarty->display('schedule.tpl');		
	}
	
	public function IsPostBack()
	{
		// TODO: Is this method needed?
		return is_null($this->GetScheduleId());
	}
	
	public function GetScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function SetScheduleId($scheduleId)
	{
		$this->smarty->assign('ScheduleId', $scheduleId);
	}
	
	public function SetSchedules($schedules)
	{
		$this->smarty->assign('Schedules', $schedules);
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
	
	public function SetDisplayDates($dateRange)
	{
		$this->smarty->assign('DisplayDates', $dateRange);
		$this->smarty->assign('BoundDates', $dateRange->Dates());
	}
	
	public function GetSelectedDate()
	{
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
	 * Sets the dates to be displayed for the schedule, adjusted for timezone if necessary
	 *
	 * @param array[int]Date $dates
	 */
	public function SetDisplayDates($dates);
	
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