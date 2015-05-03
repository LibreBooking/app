<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ReservationListingTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testReservationSpanningMultipleDaysIsReturnedOnAllOfThem()
	{
		$res1 = $this->GetReservation('2009-10-09 22:00:00', '2009-10-09 23:00:00', 1);
		// 2009-10-09 17:00:00 - 2009-10-09 18:00:00 CST
		$res2 = $this->GetReservation('2009-10-10 01:00:00', '2009-10-10 07:00:00', 2);
		// 2009-10-09 20:00:00 - 2009-10-10 02:00:00 CST
		$res3 = $this->GetReservation('2009-10-10 10:00:00', '2009-10-13 10:00:00', 1);
		// 2009-10-10 05:00:00 - 2009-10-13 05:00:00 CST
		$res4 = $this->GetReservation('2009-10-14 01:00:00', '2009-10-16 01:00:00', 2);
		// 2009-10-13 20:00:00 - 2009-10-15 20:00:00 CST
		$res5 = $this->GetReservation('2009-10-13 10:00:00', '2009-10-13 15:00:00', 1);
		// 2009-10-13 05:00:00 - 2009-10-13 10:00:00 CST

		$reservationListing = new ReservationListing("America/Chicago");

		$reservationListing->Add($res4);
		$reservationListing->Add($res1);
		$reservationListing->Add($res3);
		$reservationListing->Add($res2);
		$reservationListing->Add($res5);

		$blackout1 = new TestBlackoutItemView(1, $res1->StartDate, $res1->EndDate, $res1->ResourceId);
		$blackout2 = new TestBlackoutItemView(2, $res2->StartDate, $res2->EndDate, $res2->ResourceId);
		$reservationListing->AddBlackout($blackout1);
		$reservationListing->AddBlackout($blackout2);

		$onDate1 = $reservationListing->OnDate(Date::Parse('2009-10-09', 'CST'));
		$onDate2 = $reservationListing->OnDate(Date::Parse('2009-10-10', 'CST'));
		$onDate3 = $reservationListing->OnDate(Date::Parse('2009-10-11', 'CST'));
		$onDate4 = $reservationListing->OnDate(Date::Parse('2009-10-12', 'CST'));
		$onDate5 = $reservationListing->OnDate(Date::Parse('2009-10-13', 'CST'));
		$onDate6 = $reservationListing->OnDate(Date::Parse('2009-10-14', 'CST'));
		$onDate7 = $reservationListing->OnDate(Date::Parse('2009-10-15', 'CST'));
		$onDate8 = $reservationListing->OnDate(Date::Parse('2009-10-16', 'CST'));

		$this->assertEquals(4, $onDate1->Count(), "2 reservations 2 blackouts");
		$this->assertEquals(3, $onDate2->Count(), "2 reservations 1 blackout");
		$this->assertEquals(1, $onDate3->Count());
		$this->assertEquals(1, $onDate4->Count());
		$this->assertEquals(3, $onDate5->Count());
		$this->assertEquals(1, $onDate6->Count());
		$this->assertEquals(1, $onDate7->Count());
		$this->assertEquals(0, $onDate8->Count());

		$this->assertEquals(4, $reservationListing->ForResource(1)->Count());
		$this->assertEquals(2, $onDate1->ForResource(1)->Count());

		$this->assertEquals(2, count($reservationListing->OnDateForResource(Date::Parse('2009-10-09', 'CST'), 1)));
		$this->assertEquals(2, count($reservationListing->OnDateForResource(Date::Parse('2009-10-09', 'CST'), 2)));
		$this->assertEquals(1, count($reservationListing->OnDateForResource(Date::Parse('2009-10-10', 'CST'), 1)));
		$this->assertEquals(0, count($reservationListing->OnDateForResource(Date::Parse('2009-10-10', 'CST'), 999)));

		$date1Items = $onDate1->Reservations();
		$this->assertTrue(in_array(new ReservationListItem($res1), $date1Items));
		$this->assertTrue(in_array(new ReservationListItem($res2), $date1Items));
		$this->assertTrue(in_array(new BlackoutListItem($blackout1), $date1Items));
		$this->assertTrue(in_array(new BlackoutListItem($blackout2), $date1Items));

		$date2Items = $onDate2->Reservations();
		$this->assertTrue(in_array(new ReservationListItem($res2), $date2Items));
		$this->assertTrue(in_array(new ReservationListItem($res3), $date2Items));
		$this->assertTrue(in_array(new BlackoutListItem($blackout2), $date2Items));
	}

	public function testReservationListItemCreatesReservationSlot()
	{
		$view = new TestReservationItemView(1, Date::Parse('2011-11-22 04:34'), Date::Parse('2011-11-23 14:43'), 123);
		$item = new ReservationListItem($view);

		$this->assertEquals($view->StartDate, $item->StartDate());
		$this->assertEquals($view->EndDate, $item->EndDate());
		$this->assertEquals($view->ResourceId, $item->ResourceId());

		$start = Date::Parse('2011-12-01');
		$end = Date::Parse('2011-12-02');
		$period = new SchedulePeriod($start, $end);
		$display = Date::Parse('2011-12-03');
		$span = 3;

		$expectedSlot = new ReservationSlot($period, $period, $display, $span, $view);
		$actualSlot = $item->BuildSlot($period, $period, $display, $span);
		$this->assertEquals($expectedSlot, $actualSlot);
	}

	public function testBlackoutListItemCreatesBlackoutSlot()
	{
		$view = new TestBlackoutItemView(1, Date::Parse('2011-11-22 04:34'), Date::Parse('2011-11-23 14:43'), 123);
		$item = new BlackoutListItem($view);

		$this->assertEquals($view->StartDate, $item->StartDate());
		$this->assertEquals($view->EndDate, $item->EndDate());
		$this->assertEquals($view->ResourceId, $item->ResourceId());

		$start = Date::Parse('2011-12-01');
		$end = Date::Parse('2011-12-02');
		$period = new SchedulePeriod($start, $end);
		$display = Date::Parse('2011-12-03');
		$span = 3;

		$expectedSlot = new BlackoutSlot($period, $period, $display, $span, $view);
		$actualSlot = $item->BuildSlot($period, $period, $display, $span);
		$this->assertEquals($expectedSlot, $actualSlot);
	}

	/**
	 * @param $startDateString
	 * @param $endDateString
	 * @return ReservationItemView
	 */
	private function GetReservation($startDateString, $endDateString, $resourceId = 1)
	{
		$i = new ReservationItemView(1, Date::Parse($startDateString, 'UTC'), Date::Parse($endDateString, 'UTC'));
		$i->ResourceId = $resourceId;

		return $i;
	}
}
?>