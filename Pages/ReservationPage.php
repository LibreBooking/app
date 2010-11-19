<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

interface IReservationPage extends IPage
{
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
	 * @param UserDto $user
	 */
	public function SetReservationUser($user);
	
	/**
	 * @param ScheduleResource $resource
	 */
	public function SetReservationResource($resource);

	/**
	 * @param bool $shouldDisplay
	 */
	public function SetDisplaySaved($shouldDisplay);
}

interface INewReservationPage extends IReservationPage
{
	public function GetRequestedResourceId();
	
	public function GetRequestedScheduleId();
	
	public function GetRequestedDate();
	
	public function GetRequestedPeriod();
}

interface IExistingReservationPage extends IReservationPage
{
	
}

abstract class ReservationPage extends Page implements IReservationPage
{
	private $_displaySaveMessage = false;
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
	
	protected function __construct($title)
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
	protected abstract function GetSavedTemplateName();
	
	/**
	 * @return string
	 */
	protected abstract function GetTemplateName();
		
	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Set('ReturnUrl', $this->GetLastPage());
		$this->Set('RepeatEveryOptions', range(1, 20));
		
		if ($this->_displaySaveMessage)
		{
			$this->smarty->display($this->GetSavedTemplateName());
		}
		else
		{
			$this->smarty->display($this->GetTemplateName());		
		}
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
		throw new NotImplemented('does not do anything right now, need to implement');
		$this->Set('StartPeriod', $periodId);
	}
	
	public function SetEndPeriod($periodId)
	{
		$this->Set('EndPeriod', $periodId);
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
	
	public function SetDisplaySaved($shouldDisplay)
	{
		$this->_displaySaveMessage = true;
	}
}

class ExistingReservationPage extends ReservationPage implements IExistingReservationPage
{
	public function __construct()
	{
		parent::__construct('EditReservation');
	}
	
	protected function GetPresenter()
	{
		return null;
//		new ReservationPresenter(
//			$this, 
//			$initializationFactory,
//			$preconditionService);
	}
	
	protected function GetSavedTemplateName()
	{
		return 'reservation_saved.tpl';
	}

	protected function GetTemplateName()
	{
		return 'reservation.tpl';
	}
}

class NewReservationPage extends ReservationPage implements INewReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');
	}
	
	protected function GetPresenter()
	{
		$initializationFactory = new ReservationInitializerFactory($this->scheduleUserRepository, $this->scheduleRepository, $this->userRepository);
		$preconditionService = new NewReservationPreconditionService($this->permissionServiceFactory);
		
		return new ReservationPresenter(
			$this, 
			$initializationFactory,
			$preconditionService);
	}
	
	protected function GetSavedTemplateName()
	{
		return 'reservation_saved.tpl';
	}

	protected function GetTemplateName()
	{
		return 'reservation.tpl';
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
}
?>