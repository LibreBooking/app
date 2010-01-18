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
		$this->_page->BindAvailableResources($scheduleUser->GetAllResources());		
		
		$users = $this->_userRepository->GetAll();
		$this->_page->BindAvailableUsers($users);	
		
		$startDate = ($requestedStartDate == null) ? Date::Now()->ToTimezone($timezone) : Date::Parse($requestedStartDate, $timezone);
		$this->_page->SetStartDate($startDate);
		$this->_page->SetEndDate($startDate);
		$this->_page->SetStartPeriod($requestedPeriodId);
		$this->_page->SetEndPeriod($requestedPeriodId);
		

	}
}

interface IReservationPresenter
{}
?>