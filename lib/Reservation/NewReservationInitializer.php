<?php 
require_once(ROOT_DIR . 'lib/Reservation/ReservationInitializerBase.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');

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
	
	protected function GetStartDate()
	{
		return $this->_page->GetRequestedDate();
	}
	
	protected function GetEndDate()
	{
		return $this->_page->GetRequestedDate();
	}
	
	protected function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
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