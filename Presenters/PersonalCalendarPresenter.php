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
		$type = $this->page->GetCalendarType();

		$year = $this->page->GetYear();
		$month = $this->page->GetMonth();
		$day = $this->page->GetDay();

		$defaultDate = Date::Now()->ToTimezone($timezone);
		
		if (empty($year))
		{
			$year = $defaultDate->Year();
		}
		if (empty($month))
		{
			$month = $defaultDate->Month();
		}
		if (empty($day))
		{
			$day = $defaultDate->Day();
		}

		$calendar = $this->calendarFactory->Create($type, $year, $month, $day, $timezone);
		$reservations = $this->repository->GetReservationList($calendar->FirstDay(), $calendar->LastDay(), $userId, ReservationUserLevel::ALL);
		$calendar->AddReservations($reservations);
		$this->page->BindCalendar($calendar);

		$this->page->SetMonth($month);
		$this->page->SetDay($day);
		$this->page->SetYear($year);

		$previousDate = $calendar->GetPreviousDate();
		$this->page->SetPreviousMonth($previousDate->Month());
		$this->page->SetPreviousDay($previousDate->Day());
		$this->page->SetPreviousYear($previousDate->Year());

		$nextDate = $calendar->GetNextDate();
		$this->page->SetNextMonth($nextDate->Month());
		$this->page->SetNextDay($nextDate->Day());
		$this->page->SetNextYear($nextDate->Year());
	}
}
?>