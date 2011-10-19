<?php
require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');


class ManageReservationsActions
{
	const Approve = 'approve';
	const Delete = 'delete';
}

interface IManageReservationsService
{
	/**
	 * @abstract
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter ReservationFilter
	 * @param $user UserSession
	 * @return PageableData
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user);

	/**
	 * @abstract
	 * @param $referenceNumber string
	 * @param $seriesUpdateScope string|SeriesUpdateScope
	 * @param $user UserSession
	 * @return void
	 */
	public function Delete($referenceNumber, $seriesUpdateScope, $user);

	/**
	 * @abstract
	 * @param $referenceNumber string
	 * @param $user UserSession
	 * @return void
	 */
	public function Approve($referenceNumber, $user);
}

class ManageReservationsService implements IManageReservationsService
{
	/**
	 * @var IReservationRepository
	 */
	private $reservationRepository;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(
		IReservationRepository $reservationRepository,
		IReservationViewRepository $reservationViewRepository)
	{
		$this->reservationRepository = $reservationRepository;
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		return $this->reservationViewRepository->GetList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}

	public function Delete($referenceNumber, $seriesUpdateScope, $user)
	{
		$reservation = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

		$reservation->ApplyChangesTo($seriesUpdateScope);
		$reservation->Delete($user);
		$this->reservationRepository->Delete($reservation);
	}

	public function Approve($referenceNumber, $user)
	{
	}
}

class ManageReservationsPresenter extends ActionPresenter
{
	/**
	 * @var IManageReservationsPage
	 */
	private $page;

	/**
	 * @var IManageReservationsService
	 */
	private $manageReservationsService;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(
		IManageReservationsPage $page,
		IManageReservationsService $manageReservationsService,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->manageReservationsService = $manageReservationsService;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageReservationsActions::Delete, 'DeleteReservation');
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
		$referenceNumber = $this->page->GetReferenceNumber();
		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		$reservationStatusId = $this->page->GetReservationStatusId();
		$userId = $this->page->GetUserId();
		$userName = $this->page->GetUserName();

		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetReferenceNumber($referenceNumber);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);
		$this->page->SetUserId($userId);
		$this->page->SetUserName($userName);
		$this->page->SetReservationStatusId($reservationStatusId);

		$filter = new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId, $reservationStatusId);

		$reservations = $this->manageReservationsService->LoadFiltered($this->page->GetPageNumber(),
																	   $this->page->GetPageSize(),
																	   $filter,
																	   $session);

		$this->page->BindReservations($reservations->Results());
		$this->page->BindPageInfo($reservations->PageInfo());
	}

	public function DeleteReservation()
	{
		$session = ServiceLocator::GetServer()->GetUserSession();
		$referenceNumber = $this->page->GetDeleteReferenceNumber();
		$scope = $this->page->GetDeleteScope();

		Log::Debug('Admin: Deleting reservation %s with change scope %s', $referenceNumber, $scope);

		$this->manageReservationsService->Delete($referenceNumber, $scope, $session);
	}

	private function GetDate($dateString, $timezone, $defaultDays)
	{
		$date = null;
		if (is_null($dateString)) {
			$date = Date::Now()->AddDays($defaultDays)->ToTimezone($timezone)->GetDate();

		}
		elseif (!empty($dateString))
		{
			$date = Date::Parse($dateString, $timezone);
		}

		return $date;
	}
}

class ReservationFilter
{
	private $startDate = null;
	private $endDate = null;
	private $referenceNumber = null;
	private $scheduleId = null;
	private $resourceId = null;
	private $userId = null;

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @param int $statusId
	 */
	public function __construct($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null, $resourceId = null, $userId = null, $statusId = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->referenceNumber = $referenceNumber;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
		$this->userId = $userId;
		$this->statusId = $statusId;
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
		if (!empty($this->referenceNumber)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::REFERENCE_NUMBER, $this->referenceNumber));
		}
		if (!empty($this->scheduleId)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::SCHEDULE_ID, $this->scheduleId));
		}
		if (!empty($this->resourceId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ID), $this->resourceId));
		}
		if (!empty($this->userId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::USERS, ColumnNames::USER_ID), $this->userId));
		}
		if (!empty($this->statusId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESERVATION_SERIES_ALIAS, ColumnNames::RESERVATION_STATUS), $this->statusId));
		}

		return $filter;
	}
}

?>