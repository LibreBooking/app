<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

require_once(ROOT_DIR . 'Pages/ReservationPage.php');

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
	
	/**
	 * @param $page IReservationPage
	 * @param $scheduleUserRepository IScheduleUserRepository
	 * @param $scheduleRepository IScheduleRepository
	 * @param $userRepository IUserRepository
	 */
	public function __construct(
		$page, 
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
		$requestedEndDate = $this->GetEndDate();
		
		$userId = $this->GetOwnerId();
		$timezone = $this->GetTimezone();
		
		$layout = $this->scheduleRepository->GetLayout($requestedScheduleId, new ReservationLayoutFactory($timezone));
		$this->basePage->BindPeriods($layout->GetLayout());

		$scheduleUser = $this->scheduleUserRepository->GetUser($userId);
		
		$bindableResourceData = $this->GetBindableResourceData($scheduleUser, $requestedResourceId);
		$bindableUserData = $this->GetBindableUserData($userId);
		
		$this->basePage->BindAvailableUsers($bindableUserData->AvailableUsers);	
		$this->basePage->BindAvailableResources($bindableResourceData->AvailableResources);		
		
		$startDate = ($requestedStartDate == null) ? Date::Now()->ToTimezone($timezone) : $requestedStartDate->ToTimezone($timezone);
		$endDate = ($requestedEndDate == null) ? $startDate : $requestedEndDate->ToTimezone($timezone);
		$this->basePage->SetStartDate($startDate);
		$this->basePage->SetEndDate($endDate);
		$reservationUser = $bindableUserData->ReservationUser;
		$this->basePage->SetReservationUser($reservationUser);
		$this->basePage->SetReservationResource($bindableResourceData->ReservationResource);
		$this->basePage->SetScheduleId($requestedScheduleId);
	}
	
	protected abstract function GetResourceId();
	protected abstract function GetScheduleId();
	
	/**
	 * @return Date
	 */
	protected abstract function GetStartDate();
	
	/**
	 * @return Date
	 */
	protected abstract function GetEndDate();
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
?>