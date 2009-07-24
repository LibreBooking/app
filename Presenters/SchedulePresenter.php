<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class SchedulePresenter
{
	/**
	 * @var ISchedulePage
	 */
	private $_page;
	
	private $_scheduleRepository;
	private $_resourceRepository;
	private $_schedulePageBuilder;
	
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
	 * @param IResourceRepository $resourceRepository
	 */
	public function SetResourceRepository($resourceRepository)
	{
		$this->_resourceRepository = $resourceRepository;
	}
	
	/**
	 * @return IResourceRepository
	 */
	private function GetResourceRepository()
	{
		if (is_null($this->_resourceRepository))
		{
			$this->_resourceRepository = new ResourceRepository();
		}
		
		return $this->_resourceRepository;
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
	
//	public function PageLoad()
//	{
//		//TODO: Use a builder here
//		
//		$schedules = $this->GetScheduleRepository()->GetAll();
//		$this->_page->SetSchedules($schedules);
//		
//		$schedule = $this->GetCurrentSchedule($schedules);
//		$scheduleId = $schedule->GetId();
//		
//		$this->_page->SetResources($this->GetResourceRepository()->GetScheduleResources($scheduleId));
//		
//		$startDate = Date::Now();
//		$endDate = $startDate->AddDays($schedule->GetDaysVisible());
//		
//		$dates = $this->GetDisplayDates($startDate, $schedule->GetDaysVisible());
//		$this->_page->SetDisplayDates($dates);
//		
//		$this->_page->SetReservations($this->GetReservationService()->GetReservations(new DateRange($startDate, $endDate), $scheduleId));
//	}
	
	public function PageLoad2()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$schedules = $this->GetScheduleRepository()->GetAll();
		$builder = $this->GetPageBuilder();
		
		$currentSchedule = $builder->GetCurrentSchedule($this->_page, $schedules);
		$activeScheduleId = $currentSchedule->GetId();
		
		$builder->BindSchedules($this->_page, $schedules, $activeScheduleId);
		$scheduleDates = $builder->GetScheduleDates($user, $currentSchedule);
		$builder->BindDisplayDates($this->_page, $scheduleDates);
		
		$resourceRepository = $this->GetResourceRepository();
		$resources = $resourceRepository->GetScheduleResources($activeScheduleId);
		$reservations = $this->GetReservationService()->GetReservations($scheduleDates, 
																		$activeScheduleId, 
																		$user->Timezone);
				
		$builder->BindReservations($this->_page, $resources, $reservations, $scheduleDates);
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
	 * @param UserSession $user
	 * @param ISchedule $schedule
	 * @return DateRange
	 */
	public function GetScheduleDates($user, ISchedule $schedule);
	
	/**
	 * @param ISchedulePage $page
	 * @param DateRange $dateRange display dates in UTC
	 */
	public function BindDisplayDates(ISchedulePage $page, DateRange $dateRange);
	
	/**
	 * @param ISchedulePage $page
	 * @param array[int]Resource $resources
	 * @param array[int]ScheduleReservation $reservations
	 * @param DateRange $bindingDates
	 */
	public function BindReservations(ISchedulePage $page, $resources, $reservations, $bindingDates);
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
	
	public function GetScheduleDates($user, ISchedule $schedule)
	{
		$currentDate = Date::Now();
		$currentWeekDay = $currentDate->Weekday();
		$scheduleLength = $schedule->GetDaysVisible();
		
		$startDay = $schedule->GetWeekdayStart();
		
		// if we are on 3 and we need to start on 6, we need to go back 4 days
		// if we are on 3 and we need to start on 5, we need to go back 5 days
		// if we are on 3 and we need to start on 4, we need to go back 6 days
		// if we are on 3 and we need to start on 3, we need to go back 0 days
		// if we are on 3 and we need to start on 2, we need to go back 1 days
		// if we are on 3 and we need to start on 1, we need to go back 2 days
		// if we are on 3 and we need to start on 0, we need to go back 3 days
		
		if ($currentWeekDay < $startDay)
		{
			$adjustedDays = ($currentDay - $startDay) - 7;
		}
		
		$startDate = $currentDate->AddDays($currentWeekDay - $startDay);
		
		return new DateRange($startDate->ToUtc(), $startDate->AddDays($scheduleLength)->ToUtc());
	}
	
	public function BindDisplayDates(ISchedulePage $page, DateRange $dateRange)
	{
		throw new Exception();
	}
	
	public function BindReservations(ISchedulePage $page, $resources, $reservations, $bindingDates)
	{
		throw new Exception();
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