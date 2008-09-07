<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class SchedulePresenter
{
	/**
	 * @var ISchedulePage
	 */
	private $_page;
	
	private $_schedules;
	private $_resourceAccess;
	private $_reservationAccess;
	
	public function __construct(ISchedulePage $page)
	{
		$this->_page = $page;
	}
	
	/**
	 * @param Schedules $schedules
	 */
	public function SetSchedules($schedules)
	{
		$this->_schedules = $schedules;
	}
	
	/**
	 * @return Schedules
	 */
	private function GetSchedules()
	{
		if (is_null($this->_schedules))
		{
			$this->_schedules = new Schedules();
		}
		
		return $this->_schedules;
	}
	
	/**
	 * @param ResourceAccess $resourceAccess
	 */
	public function SetResourceAccess($resourceAccess)
	{
		$this->_resourceAccess = $resourceAccess;
	}
	
	/**
	 * @return ResourceAccess
	 */
	private function GetResourceAccess()
	{
		if (is_null($this->_resourceAccess))
		{
			$this->_resourceAccess = new ResourceAccess();
		}
		
		return $this->_resourceAccess;
	}
	
	/**
	 * @param Reservations $resourceAccess
	 */
	public function SetReservationAccess($reservationAccess)
	{
		$this->_reservationAccess = $reservationAccess;
	}
	
	/**
	 * @return Reservations
	 */
	private function GetReservationAccess()
	{
		if (is_null($this->_reservationAccess))
		{
			$this->_reservationAccess = new Reservations();
		}
		
		return $this->_reservationAccess;
	}
	
	public function PageLoad()
	{
		$schedules = $this->GetSchedules()->GetAll();
		$this->_page->SetSchedules($schedules);
		
		$schedule = $this->GetCurrentSchedule($schedules);
		$scheduleId = $schedule->GetId();
		
		$this->_page->SetResources($this->GetResourceAccess()->GetScheduleResources($scheduleId));
		
		$startDate = Date::Now();
		$endDate = Date::Now()->AddDays($schedule->GetDaysVisible());
		
		$this->_page->SetReservations($this->GetReservationAccess()->GetWithin($startDate, $endDate, $scheduleId));
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