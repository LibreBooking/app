<?php 
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');

class NewReservationInitializer extends ReservationInitializerBase
{	
	/**
	 * @var INewReservationPage
	 */
	private $_page;
	
	public function __construct(
		INewReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository
		)
	{
		$this->_page = $page;
		
		parent::__construct(
						$page, 
						$scheduleUserRepository, 
						$scheduleRepository, 
						$userRepository);
	}
	
	public function Initialize()
	{
		parent::Initialize();
	}
	
	protected function SetSelectedDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		$startPeriod = $this->GetPeriodClosestTo($schedulePeriods, $startDate);
		$this->basePage->SetSelectedStart($startPeriod->BeginDate());
		$this->basePage->SetSelectedEnd($startPeriod->EndDate());
		$this->basePage->SetRepeatTerminationDate($startPeriod->EndDate());
	}
	
	protected function GetOwnerId()
	{
		return ServiceLocator::GetServer()->GetUserSession()->UserId;
	}
	
	protected function GetResourceId()
	{
		return $this->_page->GetRequestedResourceId();
	}
	
	protected function GetScheduleId()
	{
		return $this->_page->GetRequestedScheduleId();
	}
	
	protected function GetReservationDate()
	{
		return $this->_page->GetReservationDate();
	}
	
	protected function GetStartDate()
	{
		return $this->_page->GetStartDate();
	}
	
	protected function GetEndDate()
	{
		return $this->_page->GetEndDate();
	}
	
	protected function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}
	
	/**
	 * @param SchedulePeriod[] $periods
	 * @param Date $date
	 * @return SchedulePeriod
	 */
	private function GetPeriodClosestTo($periods, $date)
	{
		for ($i = 0; $i < count($periods); $i++)
		{
			$currentPeriod = $periods[$i];
			$periodBegin = $currentPeriod->BeginDate();
			
			$now = Date::Now();
			if ($currentPeriod->IsReservable() && $periodBegin->Compare($date) >= 0 && $periodBegin->Compare(Date::Now()) >= 0)
			{
				return $currentPeriod;
			}
		}
		
		$lastIndex = count($periods) - 1;
		return $periods[$lastIndex];
	}
}

class BindableUserData
{
	public $ReservationUser;
	public $AvailableUsers;
	
	public function __construct()
	{
		$this->ReservationUser = new NullUserDto();
		$this->AvailableUsers = array();
	}
	
	public function SetReservationUser($user)
	{
		$this->ReservationUser = $user;
	}
	
	public function AddAvailableUser($user)
	{
		$this->AvailableUsers[] = $user;	
	}
}

class BindableResourceData
{
	public $ReservationResource;
	public $AvailableResources;
	
	public function __construct()
	{
		$this->ReservationResource = new NullScheduleResource();
		$this->AvailableResources = array();
	}
	
	public function SetReservationResource($resource)
	{
		$this->ReservationResource = $resource;
	}
	
	public function AddAvailableResource($resource)
	{
		$this->AvailableResources[] = $resource;	
	}
}

?>