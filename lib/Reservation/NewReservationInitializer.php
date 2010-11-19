<?php 
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

abstract class ReservationInitializerBase implements IReservationInitializer
{
	/**
	 * @var IReservationPage
	 */
	protected $basePage;
	
	/**
	 * @var IScheduleUserRepository
	 */
	protected $scheduleUserRepository;
	
	/**
	 * @var IScheduleRepository
	 */
	protected $scheduleRepository;
	
	/**
	 * @var IUserRepository
	 */
	protected $userRepository;
	
	public function __construct(
		IReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository
		)
	{
		$this->basePage = $page;
		$this->scheduleUserRepository = $scheduleUserRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->userRepository = $userRepository;
	}
	
	public function Initialize()
	{
		$requestedResourceId = $this->GetResourceId();
		$requestedScheduleId = $this->GetScheduleId();
		$requestedStartDate = $this->GetStartDate();
		$requestedPeriodId = $this->GetPeriodId();
		$userId = $this->GetOwnerId();
		$timezone = $this->GetTimezone();
		
		$layout = $this->scheduleRepository->GetLayout($requestedScheduleId, new ReservationLayoutFactory($timezone));
		$this->basePage->BindPeriods($layout->GetLayout());

		$scheduleUser = $this->scheduleUserRepository->GetUser($userId);
		
		$bindableResourceData = $this->GetBindableResourceData($scheduleUser, $requestedResourceId);
		$bindableUserData = $this->GetBindableUserData($userId);
		
		$this->basePage->BindAvailableUsers($bindableUserData->AvailableUsers);	
		$this->basePage->BindAvailableResources($bindableResourceData->AvailableResources);		
		
		$startDate = ($requestedStartDate == null) ? Date::Now()->ToTimezone($timezone) : Date::Parse($requestedStartDate, $timezone);
		$this->basePage->SetStartDate($startDate);
		$this->basePage->SetEndDate($startDate);
		$this->basePage->SetStartPeriod($requestedPeriodId);
		$this->basePage->SetEndPeriod($requestedPeriodId);
		$reservationUser = $bindableUserData->ReservationUser;
		$this->basePage->SetReservationUser($reservationUser);
		$this->basePage->SetReservationResource($bindableResourceData->ReservationResource);
	}
	
	protected abstract function GetResourceId();
	protected abstract function GetScheduleId();
	protected abstract function GetStartDate();
	protected abstract function GetPeriodId();
	protected abstract function GetOwnerId();
	protected abstract function GetTimezone();
	
	private function GetBindableUserData($userId)
	{
		$users = $this->userRepository->GetAll();	

		$bindableUserData = new BindableUserData();

		foreach ($users as $user)
		{
			if ($user->Id() != $userId)
			{
				$bindableUserData->AddAvailableUser($user);
			}
			else
			{
				$bindableUserData->SetReservationUser($user);
			}
		}
		
		return $bindableUserData;
	}
	
	private function GetBindableResourceData(IScheduleUser $scheduleUser, $requestedResourceId)
	{
		$resources = $scheduleUser->GetAllResources();
		
		$bindableResourceData = new BindableResourceData();
		
		foreach ($resources as $resource)
		{
			if ($resource->Id() != $requestedResourceId)
			{
				$bindableResourceData->AddAvailableResource($resource);
			}
			else
			{
				$bindableResourceData->SetReservationResource($resource);
			}
		}
		
		return $bindableResourceData;
	}
}

class ExistingReservationInitializer extends ReservationInitializerBase
{
	/**
	 * @var IExistingReservationPage
	 */
	private $page;
	
	public function __construct(
		IExistingReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IReservationViewRepository $reservationViewRepository
		)
	{
		$this->page = $page;
		$this->reservationViewRepoistory = $reservationViewRepository;
		
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
		throw new Exception('not implemented');
	}
	
	protected function GetResourceId()
	{
		throw new Exception('not implemented');
	}
	
	protected function GetScheduleId()
	{
		throw new Exception('not implemented');
	}
	
	protected function GetStartDate()
	{
		throw new Exception('not implemented');
	}
	
	protected function GetPeriodId()
	{
		throw new Exception('not implemented');
	}
	
	protected function GetTimezone()
	{
		throw new Exception('not implemented');
	}
}

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
	
	protected function GetPeriodId()
	{
		return $this->_page->GetRequestedPeriod();
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