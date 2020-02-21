<?php
/**
 * Copyright 2017-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Search/SearchReservationsPresenter.php');

class SearchReservationsPresenterTests extends TestBase
{
	/**
	 * @var SearchReservationsPresenter
	 */
	private $presenter;

	/**
	 * @var FakeSearchReservationsPage
	 */
	private $page;

	/**
	 * @var FakeResourceService
	 */
	private $resourceService;

	/**
	 * @var FakeReservationViewRepository
	 */
	private $reservationRepository;
	/**
	 * @var FakeScheduleService
	 */
	private $scheduleService;

	public function setUp(): void
	{
		parent::setup();

		$this->page = new FakeSearchReservationsPage();
		$this->resourceService = new FakeResourceService();
		$this->reservationRepository = new FakeReservationViewRepository();
		$this->scheduleService = new FakeScheduleService();

		$this->presenter = new SearchReservationsPresenter($this->page,
														   $this->fakeUser,
														   $this->reservationRepository,
														   $this->resourceService,
														   $this->scheduleService);

		$this->resourceService->_AllResources = array(new TestResourceDto(1, '', true, true, 1), new TestResourceDto(3, '', true, true, 2));
		$this->scheduleService->_AllSchedules = array(new FakeSchedule(1, 'schedule', true, 1));
	}

	public function testFiltersReservations()
	{
		$userId = 10;
		$resourceIds = array(10, 11);
		$scheduleIds = array(20, 21);
		$title = 'title';
		$description = 'description';
		$referenceNumber = 'refnum';
		$range = 'today';
		$reservations = array(new ReservationItemView());

		$this->page->_UserId = $userId;
		$this->page->_ResourceIds = $resourceIds;
		$this->page->_ScheduleIds = $scheduleIds;
		$this->page->_Title = $title;
		$this->page->_Description = $description;
		$this->page->_ReferenceNumber = $referenceNumber;
		$this->page->_Range = $range;

		$this->reservationRepository->_FilterResults = new PageableData($reservations);

		$this->presenter->SearchReservations();

		$today = Date::Now()->ToTimezone($this->fakeUser->Timezone)->GetDate();
		$tomorrow = Date::Now()->ToTimezone($this->fakeUser->Timezone)->AddDays(1)->GetDate();
		$expectedFilter = ReservationsSearchFilter::GetFilter($today, $tomorrow, $userId, $resourceIds, $scheduleIds, $title, $description, $referenceNumber);

		$this->assertEquals($expectedFilter, $this->reservationRepository->_Filter);
		$this->assertEquals($reservations, $this->page->_Reservations);
	}
}

class FakeSearchReservationsPage extends SearchReservationsPage
{
	public $_Reservations;

	public $_Range;
	public $_UserId;
	public $_ResourceIds;
	public $_ScheduleIds;
	public $_Title;
	public $_Description;
	public $_ReferenceNumber;

	public function SetResources($resources)
	{
	}

	public function ShowReservations($reservations, $timezone)
	{
		$this->_Reservations = $reservations;
	}

	public function GetRequestedRange()
	{
		return $this->_Range;
	}

	public function GetRequestedStartDate()
	{

	}


	public function GetRequestedEndDate() { }

	public function GetResources()
	{
		return $this->_ResourceIds;
	}

	public function GetSchedules()
	{
		return $this->_ScheduleIds;
	}

	public function GetUserId()
	{
		return $this->_UserId;
	}

	public function GetTitle()
	{
		return $this->_Title;
	}

	public function GetDescription()
	{
		return $this->_Description;
	}

	public function GetReferenceNumber()
	{
		return $this->_ReferenceNumber;
	}
}