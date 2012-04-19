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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ReservationServiceTests extends TestBase
{	
	public function setup()
	{
		parent::setup();
	}
	
	public function teardown()
	{
		parent::teardown();
	}
		
	public function testGetReservationsPullsReservationFromTheRepositoryAndAddsThemToTheCoordinator()
	{
		$timezone = 'UTC';
		$startDate = Date::Now();
		$endDate = Date::Now();
		$scheduleId = 100;
		
		$range = new DateRange($startDate, $endDate);
		
		$repository = $this->getMock('IReservationViewRepository');
		$reservationListing = new TestReservationListing();
		$listingFactory = $this->getMock('IReservationListingFactory');
		
		$rows = FakeReservationRepository::GetReservationRows();
		$res1 = ReservationItemView::Populate($rows[0]);
		$res2 = ReservationItemView::Populate($rows[1]);
		$res3 = ReservationItemView::Populate($rows[2]);

		$date = Date::Now();
		$blackout1 = new TestBlackoutItemView(1, $date, $date, 1);
		$blackout2 = new TestBlackoutItemView(2, $date, $date, 2);
		$blackout3 = new TestBlackoutItemView(3, $date, $date, 3);

		$repository
			->expects($this->once())
			->method('GetReservationList')
			->with($this->equalTo($startDate), $this->equalTo($endDate), $this->isNull(), $this->isNull(), $this->equalTo($scheduleId), $this->isNull())
			->will($this->returnValue(array($res1, $res2, $res3)));

		$repository
			->expects($this->once())
			->method('GetBlackoutsWithin')
			->with($this->equalTo(new DateRange($startDate, $endDate)), $this->equalTo($scheduleId))
			->will($this->returnValue(array($blackout1, $blackout2, $blackout3)));

		$listingFactory
			->expects($this->once())
			->method('CreateReservationListing')
			->with($this->equalTo($timezone))
			->will($this->returnValue($reservationListing));

		$service = new ReservationService($repository, $listingFactory);
		
		$listing = $service->GetReservations($range, $scheduleId, $timezone);
		
		$this->assertEquals($reservationListing, $listing);
		$this->assertTrue(in_array($res1, $reservationListing->reservations));
		$this->assertTrue(in_array($res2, $reservationListing->reservations));
		$this->assertTrue(in_array($res3, $reservationListing->reservations));
		$this->assertTrue(in_array($blackout1, $reservationListing->blackouts));
		$this->assertTrue(in_array($blackout2, $reservationListing->blackouts));
		$this->assertTrue(in_array($blackout3, $reservationListing->blackouts));
	}

}

class TestReservationListing implements IMutableReservationListing
{
	/**
	 * @var array|ReservationItemView[]
	 */
	public $reservations = array();

	/**
	 * @var array|BlackoutItemView[]
	 */
	public $blackouts = array();

	/**
	 * @return int
	 */
	public function Count()
	{
		// TODO: Implement Count() method.
	}

	/**
	 * @return array|ReservationItemView[]
	 */
	public function Reservations()
	{
		// TODO: Implement Reservations() method.
	}

	/**
	 * @param Date $date
	 * @return IDateReservationListing
	 */
	public function OnDate($date)
	{
		// TODO: Implement OnDate() method.
	}

	/**
	 * @param ReservationItemView $reservation
	 * @return void
	 */
	public function Add($reservation)
	{
		$this->reservations[] = $reservation;
	}

	/**
	 * @param BlackoutItemView $blackout
	 * @return void
	 */
	public function AddBlackout($blackout)
	{
		$this->blackouts[] = $blackout;
	}

	/**
	 * @param int $resourceId
	 * @return IReservationListing
	 */
	public function ForResource($resourceId)
	{
		// TODO: Implement ForResource() method.
	}

	/**
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|ReservationListItem[]
	 */
	public function OnDateForResource(Date $date, $resourceId)
	{
		// TODO: Implement OnDateForResource() method.
	}
}
?>