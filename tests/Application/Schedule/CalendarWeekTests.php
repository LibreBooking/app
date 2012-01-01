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

require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class CalendarWeekTests extends TestBase
{
	public function testAddsReservationsToCalendar()
	{
		$startsBeforeWeek = new ReservationItemView();
		$startsBeforeWeek->StartDate = Date::Parse('2011-07-30 12:00', 'UTC');
		$startsBeforeWeek->EndDate = Date::Parse('2011-07-31 12:00', 'UTC');

		$endsAfterWeek = new ReservationItemView();;
		$endsAfterWeek->StartDate = Date::Parse('2011-08-06 12:00', 'UTC');
		$endsAfterWeek->EndDate = Date::Parse('2012-08-08 12:00', 'UTC');

		$firstDayOnly = new ReservationItemView();
		$firstDayOnly->StartDate = Date::Parse('2011-07-31 14:00', 'UTC');
		$firstDayOnly->EndDate = Date::Parse('2011-07-31 16:25', 'UTC');

		$secondAndThirdDay = new ReservationItemView();
		$secondAndThirdDay->StartDate = Date::Parse('2011-08-01 14:00', 'UTC');
		$secondAndThirdDay->EndDate = Date::Parse('2011-08-02 16:25', 'UTC');

		$notInWeek = new ReservationItemView();
		$notInWeek->StartDate = Date::Parse('2011-11-02 14:00', 'UTC');
		$notInWeek->EndDate = Date::Parse('2011-11-03 16:25', 'UTC');

		$reservations = array($startsBeforeWeek, $endsAfterWeek, $firstDayOnly, $secondAndThirdDay, $notInWeek);

		$timezone = 'America/Chicago';

		$week = CalendarWeek::FromDate(2011, 8, 3, $timezone);
		$calendarReservations = CalendarReservation::FromViewList($reservations, $timezone);

		$week->AddReservations($calendarReservations);

		$expectedFirstDay = Date::Parse('2011-07-31', $timezone);
		$expectedLastDay = Date::Parse('2011-08-07', $timezone);

		$this->assertEquals($expectedFirstDay, $week->FirstDay());
		$this->assertEquals($expectedLastDay, $week->LastDay());

		$day1 = new CalendarDay($expectedFirstDay);
		$day1->AddReservation(CalendarReservation::FromView($startsBeforeWeek, $timezone));
		$day1->AddReservation(CalendarReservation::FromView($firstDayOnly, $timezone));

		$day2 = new CalendarDay($expectedFirstDay->AddDays(1));
		$day2->AddReservation(CalendarReservation::FromView($secondAndThirdDay, $timezone));

		$day3 = new CalendarDay($expectedFirstDay->AddDays(2));
		$day3->AddReservation(CalendarReservation::FromView($secondAndThirdDay, $timezone));

		$day4 = new CalendarDay($expectedFirstDay->AddDays(3));
		$day5 = new CalendarDay($expectedFirstDay->AddDays(4));
		$day6 = new CalendarDay($expectedFirstDay->AddDays(5));
		$day7 = new CalendarDay($expectedFirstDay->AddDays(6));
		$day7->AddReservation(CalendarReservation::FromView($endsAfterWeek, $timezone));

		/** @var $actualDays array|CalendarDay[] */
		$actualDays = $week->Days();

		$this->assertEquals(7, count($actualDays));
		$this->assertEquals($day1, $actualDays[0]);
		$this->assertEquals($day2, $actualDays[1]);
		$this->assertEquals($day3, $actualDays[2]);
		$this->assertEquals($day4, $actualDays[3]);
		$this->assertEquals($day5, $actualDays[4]);
		$this->assertEquals($day6, $actualDays[5]);
		$this->assertEquals($day7, $actualDays[6]);

		$next = Date::Parse('2011-08-07', $timezone);
		$prev = Date::Parse('2011-07-24', $timezone);

		$this->assertEquals($next, $week->GetNextDate());
		$this->assertEquals($prev, $week->GetPreviousDate());
	}
}
?>