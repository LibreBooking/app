<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class PersonalCalendarPresenter
{

	/**
	 * @var \IPersonalCalendarPage
	 */
	private $page;

	/**
	 * @var \IReservationViewRepository
	 */
	private $repository;

	/**
	 * @var \ICalendarFactory
	 */
	private $calendarFactory;

	public function __construct(IPersonalCalendarPage $page, IReservationViewRepository $repository, ICalendarFactory $calendarFactory)
	{
		$this->page = $page;
		$this->repository = $repository;
		$this->calendarFactory = $calendarFactory;
	}
	
	public function PageLoad($userId, $timezone)
	{
		$year = $this->page->GetYear();
		$month = $this->page->GetMonth();

		if (empty($year) || empty($month))
		{
			$date = Date::Now()->ToTimezone($timezone);
			$month = $date->Month();
			$year = $date->Year();
		}

		$calendarMonth = $this->calendarFactory->GetMonth($year, $month, $timezone);

		$reservations = $this->repository->GetReservationList($calendarMonth->FirstDay(), $calendarMonth->LastDay(), $userId, ReservationUserLevel::ALL);
		$calendarMonth->AddReservations($reservations);

		$this->page->Bind($calendarMonth);

		$this->page->SetMonth($month);
		$this->page->SetYear($year);

		$prevMonth = $calendarMonth->FirstDay()->AddMonths(-1);
		$this->page->SetPreviousMonth($prevMonth->Month());
		$this->page->SetPreviousYear($prevMonth->Year());

		$nextMonth = $calendarMonth->LastDay();
		$this->page->SetNextMonth($nextMonth->Month());
		$this->page->SetNextYear($nextMonth->Year());

	}
}
?>