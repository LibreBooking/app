<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

interface IReservationPage extends IPage
{
	public function GetRequestedResourceId();
	
	public function GetRequestedScheduleId();
	
	public function GetRequestedDate();
	
	public function GetRequestedPeriod();
	
	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param array[int]ISchedulePeriod
	 */
	public function BindPeriods($periods);
	
	/**
	 * Set the resources that can be reserved by this user
	 * @param array[int]ScheduleResource
	 */
	public function BindAvailableResources($resources);
	
	/**
	 * Set the resources that can be reserved by this user
	 * @param array[int]ScheduleResource
	 */
	public function BindAvailableUsers($resources);
	
	/**
	 * @param Date $startDate
	 */
	public function SetStartDate(Date $startDate);
	
	/**
	 * @param Date $startDate
	 */
	public function SetEndDate(Date $startDate);
	
	/**
	 * @param unknown_type $periodId
	 */
	public function SetStartPeriod($periodId);

	/**
	 * @param unknown_type $periodId
	 */
	public function SetEndPeriod($periodId);
	
	/**
	 * @param string $name
	 */
	public function SetReservationUserName($name);
	
	/**
	 * @param ScheduleResource $resource
	 */
	public function SetReservationResource($resource);

}

class ReservationPage extends Page implements IReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');
		
		$scheduleUserRepository = new ScheduleUserRepository();
		$scheduleRepository = new ScheduleRepository();
		$userRepository = new UserRepository();
		$permissionServiceFactory = new PermissionServiceFactory();
		
		$initializationFactory = new ReservationInitializerFactory($scheduleUserRepository, $scheduleRepository, $userRepository);
		$preconditionService = new ReservationPreconditionService($permissionServiceFactory);
		
		$this->_presenter = new ReservationPresenter(
			$this, 
			$initializationFactory,
			$preconditionService);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->Set('ReturnUrl', $this->GetLastPage());
		$this->smarty->display('reservation.tpl');		
	}
	
	public function GetRequestedResourceId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetRequestedScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function GetRequestedDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::RESERVATION_DATE);
	}
	
	public function GetRequestedPeriod()
	{
		return $this->server->GetQuerystring(QueryStringKeys::PERIOD_ID);	
	}
	
	public function BindPeriods($periods)
	{
		$this->Set('Periods', $periods);
	}
	
	public function BindAvailableResources($resources)
	{
		$this->Set('AvailableResources', $resources);
	}
	
	public function BindAvailableUsers($users)
	{
		$this->Set('AvailableUsers', $users);
	}
	
	public function SetStartDate(Date $startDate)
	{
		$this->Set('StartDate', $startDate);
	}
	
	public function SetEndDate(Date $startDate)
	{
		$this->Set('EndDate', $startDate);
	}
	
	public function SetStartPeriod($periodId)
	{
		$this->Set('StartPeriod', $periodId);
	}
	
	public function SetEndPeriod($periodId)
	{
		$this->Set('EndPeriod', $periodId);
	}
	
	public function SetReservationUserName($name)
	{
		$this->Set('UserName', $name);
	}
	
	/**
	 * @see IReservationPage::SetReservationResource()
	 */
	public function SetReservationResource($resource)
	{
		$this->Set('ResourceName', $resource->Name());
	}
}


?>