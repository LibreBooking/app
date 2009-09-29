<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

class SchedulePage extends Page implements ISchedulePage
{
	public function __construct()
	{
		parent::__construct('Schedule');
		
		$scheduleRepository = new ScheduleRepository();
		$resourceService = new ResourceService(new ResourceRepository(), new PermissionService());
		$pageBuilder = new SchedulePageBuilder();
		$permissionService = new PermissionService();
		$reservationService = new ReservationService(new ReservationRepository(), new ReservationCoordinatorFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();
		$this->_presenter = new SchedulePresenter($this, $scheduleRepository, $resourceService, $pageBuilder, $permissionService, $reservationService, $dailyLayoutFactory);
		
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
	
	public function SetLayout($scheduleLayout)
	{
		$this->smarty->assign('Layout', $scheduleLayout);
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
	 * Sets the layout to be used when presenting reservations
	 * @param IScheduleLayout
	 */
	public function SetLayout($scheduleLayout);
	
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