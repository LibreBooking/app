<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

interface ISchedulePresenter
{
	public function PageLoad();
}

class SchedulePresenter implements ISchedulePresenter
{
	/**
	 * @var ISchedulePage
	 */
	private $_page;
	
	private $_scheduleRepository;
	private $_resourceService;
	private $_schedulePageBuilder;
	private $_permissionService;
	
	/**
	 * @var IReservationService
	 */
	private $_reservationService;
	
	public function __construct(ISchedulePage $page)
	{
		$this->_page = $page;
	}
	
	/**
	 * @param IScheduleRepository $scheduleRepository
	 */
	public function SetScheduleRepository($scheduleRepository)
	{
		$this->_scheduleRepository = $scheduleRepository;
	}
	
	/**
	 * @return IScheduleRepository
	 */
	private function GetScheduleRepository()
	{
		if (is_null($this->_scheduleRepository))
		{
			$this->_scheduleRepository = new ScheduleRepository();
		}
		
		return $this->_scheduleRepository;
	}
	
	/**
	 * @param IResourceService $resourceService
	 */
	public function SetResourceService(IResourceService $resourceService)
	{
		$this->_resourceService = $resourceService;
	}
	
	/**
	 * @return IResourceService
	 */
	private function GetResourceService()
	{
		if (is_null($this->_resourceService))
		{
			$this->_resourceService = new ResourceService(new ResourceRepository(), new PermissionService());
		}
		
		return $this->_resourceService;
	}
	
	/**
	 * @param IReservationService $reservationService
	 */
	public function SetReservationService($reservationService)
	{
		$this->_reservationService = $reservationService;
	}
	
	/**
	 * @return IReservationService
	 */
	private function GetReservationService()
	{
		if (is_null($this->_reservationService))
		{
			$this->_reservationService = new ReservationSerivce();
		}
		
		return $this->_reservationService;
	}
	
 	/** 
 	 * @param ISchedulePageBuilder $schedulePageBuilder
	 */
	public function SetPageBuilder($schedulePageBuilder)
	{
		$this->_schedulePageBuilder = $schedulePageBuilder;
	}
	
	/**
	 * @return ISchedulePageBuilder
	 */
	private function GetPageBuilder()
	{
		if (is_null($this->_schedulePageBuilder))
		{
			$this->_schedulePageBuilder = new SchedulePageBuilder();
		}
		
		return $this->_schedulePageBuilder;
	}
	
	public function SetPermissionService(IPermissionService $permissionService)
	{
		$this->_permissionService = $permissionService;
	}
	
	/**
	 * @return IPermissionService
	 */
	public function GetPermissionService()
	{
		if (is_null($this->_permissionService))
		{
			$this->_permissionService = null;
			throw new Exception("not implemented");
		}
		
		return $this->_permissionService;
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$scheduleRepository = $this->GetScheduleRepository();
		$schedules = $scheduleRepository->GetAll();
		$builder = $this->GetPageBuilder();
		
		$currentSchedule = $builder->GetCurrentSchedule($this->_page, $schedules);
		$activeScheduleId = $currentSchedule->GetId();
		$builder->BindSchedules($this->_page, $schedules, $activeScheduleId);
		
		$scheduleDates = $builder->GetScheduleDates($user, $currentSchedule, $this->_page);
		$builder->BindDisplayDates($this->_page, $scheduleDates, $user);
				
		$layout = $scheduleRepository->GetLayout($activeScheduleId);														
		
		$reservations = $this->GetReservationService()->GetReservations($scheduleDates, 
																		$activeScheduleId, 
																		$user->Timezone,
																		$layout);
		
		$resourceService = $this->GetResourceService();
		$resources = $resourceService->GetScheduleResources($activeScheduleId);
		
		$builder->BindLayout($this->_page, $layout);															
		$builder->BindReservations($this->_page, $resources, $reservations);
	}
	
	/**
	 * @param Date $startDate
	 * @param int $daysVisible
	 * @return array[int]Date 
	 */
	private function GetDisplayDates($startDate, $daysVisible)
	{
		$dates = array();
		$user = ServiceLocator::GetServer()->GetUserSession();
		for($dateCount = 0; $dateCount < $daysVisible; $dateCount++)
		{
			$date = $startDate->AddDays($dateCount);
			$dates[$date->Timestamp()] = $date->ToTimezone($user->Timezone);
		}
		
		return $dates;
	}
}

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
	 * @param IReservationListing $reservations
	 */
	public function BindReservations(ISchedulePage $page, $resources, IReservationListing $reservations);
	
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
	
	public function BindReservations(ISchedulePage $page, $resources, IReservationListing $reservations)
	{
		$page->SetResources($resources);
		$page->SetReservations($reservations);
	}
	
	public function BindLayout(ISchedulePage $page, IScheduleLayout $layout)
	{
		// TODO: This may be better off taking an array of SchedulePeriods
		$page->SetLayout($layout);
	}
	
	public function BindLayout(ISchedulePage $page, $schedulePeriods)
	{
		$page->SetLayout($schedulePeriods);
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