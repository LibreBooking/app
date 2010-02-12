<?php 
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class ReservationPresenter implements IReservationPresenter
{
	/**
	 * @var IReservationPage
	 */
	private $_page;
	
	/**
	 * @var IScheduleUserRepository
	 */
	private $_scheduleUserRepository;
	
	/**
	 * @var IScheduleRepository
	 */
	private $_scheduleRepository;
	
	/**
	 * @var IUserRepository
	 */
	private $_userRepository;
	
	public function __construct(
		IReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository, 
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository)
	{
		$this->_page = $page;
		$this->_scheduleUserRepository = $scheduleUserRepository;
		$this->_scheduleRepository = $scheduleRepository;
		$this->_userRepository = $userRepository;
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$timezone = $user->Timezone;
		$userId = $user->UserId;
		
		$requestedResourceId = $this->_page->GetRequestedResourceId();
		$requestedScheduleId = $this->_page->GetRequestedScheduleId();
		$requestedStartDate = $this->_page->GetRequestedDate();
		$requestedPeriodId = $this->_page->GetRequestedPeriod();
		
		$layout = $this->_scheduleRepository->GetLayout($requestedScheduleId, $timezone);
		$this->_page->BindPeriods($layout->GetLayout());

		$scheduleUser = $this->_scheduleUserRepository->GetUser($userId);
		
		$bindableResourceData = $this->GetBindableResourceData($scheduleUser, $requestedResourceId);
		$bindableUserData = $this->GetBindableUserData($userId);
		
		$this->_page->BindAvailableUsers($bindableUserData->AvailableUsers);	
		$this->_page->BindAvailableResources($bindableResourceData->AvailableResources);		
		
		$startDate = ($requestedStartDate == null) ? Date::Now()->ToTimezone($timezone) : Date::Parse($requestedStartDate, $timezone);
		$this->_page->SetStartDate($startDate);
		$this->_page->SetEndDate($startDate);
		$this->_page->SetStartPeriod($requestedPeriodId);
		$this->_page->SetEndPeriod($requestedPeriodId);
		$reservationUser = $bindableUserData->ReservationUser;
		$this->_page->SetReservationUserName("{$reservationUser->FirstName()} {$reservationUser->LastName()}");
		$this->_page->SetReservationResource($bindableResourceData->ReservationResource);
	}
	
	private function GetBindableUserData($userId)
	{
		$users = $this->_userRepository->GetAll();	

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
	
	private function GetBindableResourceData($scheduleUser, $requestedResourceId)
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

interface IReservationPresenter
{}
?>