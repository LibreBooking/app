<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
			->method('BindCalendar')
			->with($this->equalTo($month));

		$this->presenter->PageLoad($userId, $userTimezone);
	}
}
?>