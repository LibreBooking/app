<?php
require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ManageReservationsPresenter
{
	/**
	 * @var \IManageReservationsPage
	 */
	private $page;

	/**
	 * @var \IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var \IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var \IResourceRepository
	 */
	private $resourceRepository;
	
	public function __construct(
		IManageReservationsPage $page,
		IReservationViewRepository $reservationViewRepository,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository)
	{
		$this->page = $page;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;
	}
	
	public function PageLoad($userTimezone)
	{
		$this->page->BindSchedules($this->scheduleRepository->GetAll());
		$this->page->BindResources($this->resourceRepository->GetResourceList());
		
		$startDateString = $this->page->GetStartDate();
		$endDateString = $this->page->GetEndDate();

		$startDate = $this->GetDate($startDateString, $userTimezone, -7);
		$endDate = $this->GetDate($endDateString, $userTimezone, 7);
		$referenceNumber = $this->page->GetReferenceNumber();
		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		$userId = $this->page->GetUserId();
		$userName = $this->page->GetUserName();

		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetReferenceNumber($referenceNumber);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);
		$this->page->SetUserId($userId);
		$this->page->SetUserName($userName);

		$filter = new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId);

		$reservations = $this->reservationViewRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize(), null, null, $filter->GetFilter());

		$this->page->BindReservations($reservations->Results());
		$this->page->BindPageInfo($reservations->PageInfo());
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
	 */
	public function __construct($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null, $resourceId = null, $userId = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->referenceNumber = $referenceNumber;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
		$this->userId = $userId;
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();

		if (!empty($this->startDate))
		{
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $this->startDate->ToDatabase()));
		}
		if (!empty($this->endDate))
		{
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $this->endDate->ToDatabase()));
		}
		if (!empty($this->referenceNumber))
		{
			$filter->_And(new SqlFilterEquals(ColumnNames::REFERENCE_NUMBER, $this->referenceNumber));
		}
		if (!empty($this->scheduleId))
		{
			$filter->_And(new SqlFilterEquals(ColumnNames::SCHEDULE_ID, $this->scheduleId));
		}
		if (!empty($this->resourceId))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ID), $this->resourceId));
		}
		if (!empty($this->userId))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::USERS, ColumnNames::USER_ID), $this->userId));
		}

		return $filter;
	}
}

?>
