<?php
require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

interface IManageBlackoutsService
{
	/**
	 * @abstract
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter BlackoutFilter
	 * @param $user UserSession
	 * @return PageableData
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user);
}

class ManageBlackoutsService implements IManageBlackoutsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		return $this->reservationViewRepository->GetBlackoutList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}
}

class ManageBlackoutsPresenter extends ActionPresenter
{
	/**
	 * @var IManageBlackoutsPage
	 */
	private $page;

	/**
	 * @var IManageBlackoutsService
	 */
	private $manageBlackoutsService;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(
		IManageBlackoutsPage $page,
		IManageBlackoutsService $manageBlackoutsService,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->manageBlackoutsService = $manageBlackoutsService;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;
	}

	public function PageLoad($userTimezone)
	{
		$session = ServiceLocator::GetServer()->GetUserSession();

		$this->page->BindSchedules($this->scheduleRepository->GetAll());
		$this->page->BindResources($this->resourceRepository->GetResourceList());

		$startDateString = $this->page->GetStartDate();
		$endDateString = $this->page->GetEndDate();

		$startDate = $this->GetDate($startDateString, $userTimezone, -7);
		$endDate = $this->GetDate($endDateString, $userTimezone, 7);
		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		
		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);

		$filter = new BlackoutFilter($startDate, $endDate, $scheduleId, $resourceId);

		$blackouts = $this->manageBlackoutsService->LoadFiltered($this->page->GetPageNumber(),
																	   $this->page->GetPageSize(),
																	   $filter,
																	   $session);

		$this->page->BindBlackouts($blackouts->Results());
		$this->page->BindPageInfo($blackouts->PageInfo());

		$this->page->ShowPage();
	}

	private function GetDate($dateString, $timezone, $defaultDays)
	{
		$date = null;
		if (is_null($dateString))
		{
			$date = Date::Now()->AddDays($defaultDays)->ToTimezone($timezone)->GetDate();

		}
		elseif (!empty($dateString))
		{
			$date = Date::Parse($dateString, $timezone);
		}

		return $date;
	}

}

class BlackoutFilter
{
	private $startDate = null;
	private $endDate = null;
	private $scheduleId = null;
	private $resourceId = null;

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $scheduleId
	 * @param int $resourceId
	 */
	public function __construct($startDate = null, $endDate = null, $scheduleId = null, $resourceId = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();

		if (!empty($this->startDate)) {
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $this->startDate->ToDatabase()));
		}
		if (!empty($this->endDate)) {
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $this->endDate->ToDatabase()));
		}
		if (!empty($this->scheduleId)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::SCHEDULE_ID, $this->scheduleId));
		}
		if (!empty($this->resourceId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ID), $this->resourceId));
		}

		return $filter;
	}
}

?>