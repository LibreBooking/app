<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
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
	
	/**
	 * @var IReservationService
	 */
	private $_reservationService;
	
	public function __construct(ISchedulePage $page)
	{
		$this->_page = $page;
	}
	
	/**
	 * @param ScheduleRepository $scheduleRepository
	 */
	public function SetScheduleRepository($scheduleRepository)
	{
		$this->_scheduleRepository = $scheduleRepository;
	}
	
	/**
	 * @return ScheduleRepository
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
	 * @param ResourceRepository $resourceRepository
	 */
	public function SetResourceRepository($resourceRepository)
	{
		$this->_resourceRepository = $resourceRepository;
	}
	
	/**
	 * @return ResourceRepository
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
	
	public function PageLoad()
	{
		//TODO: Use a builder here
		
		$schedules = $this->GetScheduleRepository()->GetAll();
		$this->_page->SetSchedules($schedules);
		
		$schedule = $this->GetCurrentSchedule($schedules);
		$scheduleId = $schedule->GetId();
		
		$this->_page->SetResources($this->GetResourceRepository()->GetScheduleResources($scheduleId));
		
		$startDate = Date::Now();
		$endDate = $startDate->AddDays($schedule->GetDaysVisible());
		
		$dates = $this->GetDisplayDates($startDate, $schedule->GetDaysVisible());
		$this->_page->SetDisplayDates($dates);
		
		$this->_page->SetReservations($this->GetReservationService()->GetReservations(new DateRange($startDate, $endDate), $scheduleId));
	}
	
	/**
	 * @param Date $startDate
	 * @param int $daysVisible
	 * @return array[]Date 
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
	
	/**
	 * @param array Schedule $schedules
	 * @return Schedule
	 */
	public function GetCurrentSchedule($schedules)
	{
		$schedule = null;
		
		if ($this->_page->IsPostBack())
		{
			$schedule = $this->GetSchedule($schedules, $scheduleId);
		}
		else
		{
			$schedule = $this->GetDefaultSchedule($schedules);
		}
		
		return $schedule;
	}
	
	/**
	 * @param array Schedule $schedules
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
	 * @param array Schedule $schedules
	 * @param int $scheduleId
	 * @return Schedule
	 */
	private function GetSchedule($schedules, $scheduleId)
	{
		foreach ($schedules as $schedule)
		{
			if ($schedule->GetId() == $scheduleId)
			{
				return $schedule;
			}
		}
	}
}
?>