<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');

interface IReservationPage extends IPage
{
	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param array[int]ISchedulePeriod
	 */
	function BindPeriods($periods);
	
	/**
	 * Set the resources that can be reserved by this user
	 * @param array[int]ScheduleResource
	 */
	function BindAvailableResources($resources);
	
	/**
	 * Set the resources that can be reserved by this user
	 * @param array[int]ScheduleResource
	 */
	function BindAvailableUsers($resources);
	
	/**
	 * @param Date $startDate
	 */
	function SetStartDate(Date $startDate);
	
	/**
	 * @param Time $startTime
	 */
	function SetStartTime(Time $startTime);
	
	/**
	 * @param Date $startDate
	 */
	function SetEndDate(Date $startDate);
	
	/**
	 * @param Time $endTime
	 */
	function SetEndTime(Time $endTime);
	
	/**
	 * @param UserDto $user
	 */
	function SetReservationUser($user);
	
	/**
	 * @param ScheduleResource $resource
	 */
	function SetReservationResource($resource);

	/**
	 * @param int $scheduleId
	 */
	function SetScheduleId($scheduleId);
}

abstract class ReservationPage extends Page implements IReservationPage
{
	protected $presenter;
	
	/**
	 * @var ScheduleUserRepository
	 */
	protected $scheduleUserRepository;
	
	/**
	 * @var ScheduleRepository
	 */
	protected $scheduleRepository;
	
	/**
	 * @var UserRepository
	 */
	protected $userRepository;
	
	/**
	 * @var PermissionServiceFactory
	 */
	protected $permissionServiceFactory;
	
	protected function __construct($title = null)
	{
		parent::__construct($title);
		
		$this->scheduleUserRepository = new ScheduleUserRepository();
		$this->scheduleRepository = new ScheduleRepository();
		$this->userRepository = new UserRepository();
		$this->permissionServiceFactory = new PermissionServiceFactory();
		
		$this->presenter = $this->GetPresenter();
	}
	
	/**
	 * @return IReservationPresenter
	 */
	protected abstract function GetPresenter();
	
	/**
	 * @return string
	 */
	protected abstract function GetTemplateName();
	
	/**
	 * @return string
	 */
	protected abstract function GetReservationAction();
		
	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Set('ReturnUrl', $this->GetLastPage(Pages::SCHEDULE));
		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('ReservationAction', $this->GetReservationAction());
		
		$this->smarty->display($this->GetTemplateName());		
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
		$this->SetRepeatTerminationDate($startDate);
	}
	
	public function SetStartTime(Time $startTime)
	{
		$this->Set('StartTime', $startTime);
	}
	
	public function SetEndDate(Date $startDate)
	{
		$this->Set('EndDate', $startDate);
	}
	
	public function SetEndTime(Time $endTime)
	{
		$this->Set('EndTime', $endTime);
	}
	
	public function SetReservationUser($user)
	{
		$this->Set('UserName', $user->FullName());
		$this->Set('UserId', $user->Id());
	}
	
	/**
	 * @see IReservationPage::SetReservationResource()
	 */
	public function SetReservationResource($resource)
	{
		$this->Set('ResourceName', $resource->Name());
		$this->Set('ResourceId', $resource->Id());
	}
	
	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}
	
	public function SetRepeatTerminationDate($repeatTerminationDate)
	{
		$this->Set('RepeatTerminationDate', $repeatTerminationDate);
	}
}
?>