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
	 * @param Date $selectedStart
	 */
	function SetSelectedStart(Date $selectedStart);
	
	/**
	 * @param Date $selectedEnd
	 */
	function SetSelectedEnd(Date $selectedEnd);
	
	/**
	 * @param $repeatTerminationDate Date
	 */
	function SetRepeatTerminationDate($repeatTerminationDate);
	
	/**
	 * @param UserDto $user
	 */
	function SetReservationUser(UserDto $user);
	
	/**
	 * @param ScheduleResource $resource
	 */
	function SetReservationResource($resource);

	/**
	 * @param int $scheduleId
	 */
	function SetScheduleId($scheduleId);

	/**
	 * @abstract
	 * @param ReservationUserView[] $participants
	 * @return void
	 */
	function SetParticipants($participants);

	/**
	 * @abstract
	 * @param ReservationUserView[] $invitees
	 * @return void
	 */
	function SetInvitees($invitees);
}

abstract class ReservationPage extends SecurePage implements IReservationPage
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
	
	public function __construct($title = null)
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
		$this->Set('RepeatOptions', array (
						'none' => array('key' => 'DoesNotRepeat', 'everyKey' => ''),
						'daily' => array('key' => 'Daily', 'everyKey' => 'days'),
						'weekly' => array('key' => 'Weekly', 'everyKey' => 'weeks'),
						'monthly' => array('key' => 'Monthly', 'everyKey' => 'months'),
						'yearly' => array('key' => 'Yearly', 'everyKey' => 'years'),
								)
		);
		$this->Set('DayNames', array(
								0 => 'DaySundayAbbr',
								1 => 'DayMondayAbbr',
								2 => 'DayTuesdayAbbr',
								3 => 'DayWednesdayAbbr',
								4 => 'DayThursdayAbbr',
								5 => 'DayFridayAbbr',
								6 => 'DaySaturdayAbbr',
								)
		);
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
	
	public function SetSelectedStart(Date $selectedStart)
	{
		$this->Set('SelectedStart', $selectedStart);
	}
	
	public function SetSelectedEnd(Date $selectedEnd)
	{
		$this->Set('SelectedEnd', $selectedEnd);
	}

	/**
	 * @param UserDto $user
	 * @return void
	 */
	public function SetReservationUser(UserDto $user)
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

	public function SetParticipants($participants)
	{
		$this->Set('Participants', $participants);
	}

	public function SetInvitees($invitees)
	{
		$this->Set('Invitees', $invitees);
	}
}
?>