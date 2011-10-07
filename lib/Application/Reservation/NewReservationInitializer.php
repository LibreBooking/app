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
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization
		)
	{
		$this->_page = $page;
		
		parent::__construct(
						$page, 
						$scheduleRepository, 
						$userRepository,
						$resourceService,
						$reservationAuthorization);
	}
	
	public function Initialize()
	{
		parent::Initialize();
	}
	
	protected function SetSelectedDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		parent::SetSelectedDates($startDate, $endDate, $schedulePeriods);
		$this->basePage->SetRepeatTerminationDate($endDate);
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
}

class BindableResourceData
{
	/**
	 * @var ResourceDto
	 */
	public $ReservationResource;

	/**
	 * @var array|ResourceDto[]
	 */
	public $AvailableResources;
	
	public function __construct()
	{
		$this->ReservationResource = new NullScheduleResource();
		$this->AvailableResources = array();
	}

	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function SetReservationResource($resource)
	{
		$this->ReservationResource = $resource;
	}

	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function AddAvailableResource($resource)
	{
		$this->AvailableResources[] = $resource;	
	}
}

?>