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
		$month = $this->calendarFactory->GetMonth($this->page->GetYear(), $this->page->GetMonth(), $timezone);

		$reservations = $this->repository->GetReservationList($month->FirstDay(), $month->LastDay(), $userId, ReservationUserLevel::ALL);
		$month->AddReservations($reservations);

		$this->page->Bind($month);
	}
}
?>