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
	
	public function __construct(IManageReservationsPage $page, IReservationViewRepository $reservationViewRepository)
	{
		$this->page = $page;
		$this->reservationViewRepository = $reservationViewRepository;
	}
	
	public function PageLoad($userTimezone)
	{
		$startDateString = $this->page->GetStartDate();
		$endDateString = $this->page->GetEndDate();

		$startDate = $this->GetDate($startDateString, $userTimezone, -7);
		$endDate = $this->GetDate($endDateString, $userTimezone, 7);

		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);

		$filter = new ReservationFilter($startDate, $endDate);

		$reservations = $this->reservationViewRepository->GetList(1, 50, null, null, $filter->GetFilter());

		$this->page->BindReservations($reservations->Results());
		$this->page->SetPageInfo($reservations->PageInfo());
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
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();

		if (!is_null($this->startDate))
		{
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $this->startDate->ToDatabase()));
		}
		if (!is_null($this->endDate))
		{
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $this->endDate->ToDatabase()));
		}

		return $filter;
	}
}

?>
