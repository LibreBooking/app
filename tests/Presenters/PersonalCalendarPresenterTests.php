<?php
require_once(ROOT_DIR . 'Pages/PersonalCalendarPage.php');
require_once(ROOT_DIR . 'Presenters/PersonalCalendarPresenter.php');

class PersonalCalendarPresenterTests extends TestBase
{
	/**
	 * @var IPersonalCalendarPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var PersonalCalendarPresenter
	 */
	private $presenter;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repository;

	/**
	 * @var ICalendarFactory|PHPUnit_Framework_MockObject_MockObject
	 */
	private $calendarFactory;
	
	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IPersonalCalendarPage');
		$this->repository = $this->getMock('IReservationViewRepository');
		$this->calendarFactory = $this->getMock('ICalendarFactory');

		$this->presenter = new PersonalCalendarPresenter($this->page, $this->repository, $this->calendarFactory);
	}

	public function testBindsEmptyCalendarToPageWhenNoReservationsAreFound()
	{
		$userId = 10;
		$userTimezone = "America/New_York";

		$calendarType = CalendarTypes::Month;
		
		$requestedDay = 4;
		$requestedMonth = 3;
		$requestedYear = 2011;

		$month = new CalendarMonth($requestedMonth, $requestedYear, $userTimezone);

		$reservations = array();

		$this->repository->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($month->FirstDay()), $this->equalTo($month->LastDay()), $this->equalTo($userId), $this->equalTo(ReservationUserLevel::ALL))
			->will($this->returnValue($reservations));

		$this->page->expects($this->once())
				->method('GetCalendarType')
				->will($this->returnValue($calendarType));
		
		$this->page->expects($this->once())
				->method('GetDay')
				->will($this->returnValue($requestedDay));
		
		$this->page->expects($this->once())
				->method('GetMonth')
				->will($this->returnValue($requestedMonth));

		$this->page->expects($this->once())
				->method('GetYear')
				->will($this->returnValue($requestedYear));

		$this->calendarFactory->expects($this->once())
			->method('Create')
			->with($this->equalTo($calendarType), $this->equalTo($requestedYear), $this->equalTo($requestedMonth), $this->equalTo($requestedDay), $this->equalTo($userTimezone))
			->will($this->returnValue($month));

		$this->page->expects($this->once())
			->method('BindMonth')
			->with($this->equalTo($month));

		$this->presenter->PageLoad($userId, $userTimezone);
	}
}
?>