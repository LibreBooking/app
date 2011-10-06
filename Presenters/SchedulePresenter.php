<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/SchedulePageBuilder.php');

interface ISchedulePresenter
{
	public function PageLoad();
}

class SchedulePresenter implements ISchedulePresenter
{
	/**
	 * @var ISchedulePage
	 */
	private $_page;
	/**
	 * @var IScheduleRepository
	 */
	private $_scheduleRepository;
	/**
	 * @var IResourceService
	 */
	private $_resourceService;
	/**
	 * @var ISchedulePageBuilder
	 */
	private $_builder;
	/**
	 * @var IPermissionServiceFactory
	 */
	private $_permissionServiceFactory;
	/**
	 * @var IReservationService
	 */
	private $_reservationService;
	
	/**
	 * @param ISchedulePage $page
	 * @param IScheduleRepository $scheduleRepository
	 * @param IResourceService $resourceService
	 * @param ISchedulePageBuilder $schedulePageBuilder
	 * @param IPermissionServiceFactory $permissionServiceFactory
	 * @param IReservationService $reservationService
	 * @param IDailyLayoutFactory $dailyLayoutFactory
	 */
	public function __construct(
		ISchedulePage $page, 
		IScheduleRepository $scheduleRepository,
		IResourceService $resourceService,
		ISchedulePageBuilder $schedulePageBuilder,
		IPermissionServiceFactory $permissionServiceFactory,
		IReservationService $reservationService,
		IDailyLayoutFactory $dailyLayoutFactory
	)
	{
		$this->_page = $page;
		$this->_scheduleRepository = $scheduleRepository;
		$this->_resourceService = $resourceService;
		$this->_builder = $schedulePageBuilder;
		$this->_permissionServiceFactory = $permissionServiceFactory;
		$this->_reservationService = $reservationService;
		$this->_dailyLayoutFactory = $dailyLayoutFactory;
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$targetTimezone = $user->Timezone;
		
		$showInaccessibleResources = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES, new BooleanConverter());
		
		$schedules = $this->_scheduleRepository->GetAll();
		$currentSchedule = $this->_builder->GetCurrentSchedule($this->_page, $schedules);
		$activeScheduleId = $currentSchedule->GetId();
		$this->_builder->BindSchedules($this->_page, $schedules, $currentSchedule);

		$scheduleDates = $this->_builder->GetScheduleDates($user, $currentSchedule, $this->_page);
		$this->_builder->BindDisplayDates($this->_page, $scheduleDates, $user, $currentSchedule);
				
		$layout = $this->_scheduleRepository->GetLayout($activeScheduleId, new ScheduleLayoutFactory($targetTimezone));														
		
		$reservationListing = $this->_reservationService->GetReservations($scheduleDates, $activeScheduleId, $targetTimezone);
		$dailyLayout = $this->_dailyLayoutFactory->Create($reservationListing, $layout);
		$permissionService = $this->_permissionServiceFactory->GetPermissionService($user->UserId);
		$resources = $this->_resourceService->GetScheduleResources($activeScheduleId, $showInaccessibleResources, $permissionService, $user);

		$this->_builder->BindLayout($this->_page, $dailyLayout, $scheduleDates);															
		$this->_builder->BindReservations($this->_page, $resources, $dailyLayout);
	}
	
	/**
	 * @param Date $startDate
	 * @param int $daysVisible
	 * @return array[int]Date 
	 */
	private function GetDisplayDates($startDate, $daysVisible)
	{
		$dates = array();
		$user = ServiceLocator::GetServer()->GetUserSession();
		for($dateCount = 0; $dateCount < $daysVisible; $dateCount++)
		{
			$date = $startDate->AddDays($dateCount);
			$dates[$date->Timestamp()] = $date->ToTimezone($user->Timezone);
		}
		
		return $dates;
	}
}
?>