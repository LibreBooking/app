<?php
/**
 * Copyright 2018-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class ScheduleAvailabilityRuleTests extends TestBase
{
    /**
     * @var FakeScheduleRepository
     */
    public $scheduleRepository;

    /**
     * @var ScheduleAvailabilityRule
     */
    public $rule;

    public function setup()
    {
        parent::setup();

        $this->scheduleRepository = new FakeScheduleRepository();

        $this->rule = new ScheduleAvailabilityRule($this->scheduleRepository);
    }

    public function testRuleIsValidIfScheduleDoesNotHaveAvailability()
    {
        $schedule = new FakeSchedule();
        $schedule->SetAvailableAllYear();
        $this->scheduleRepository->_Schedule = $schedule;

        $startDate = Date::Parse('2010-04-04', 'UTC');
        $endDate = Date::Parse('2010-04-05', 'UTC');

        $reservation = new TestReservationSeries();

        $dr1 = new DateRange($startDate, $endDate);
        $reservation->WithDuration($dr1);

        $result = $this->rule->Validate($reservation, null);

        $this->assertTrue($result->IsValid());
    }

    public function testRuleIsValidIfFirstAndLastReservationDatesAreWithinAvailabilityBounds()
    {
        $begin = Date::Parse('2018-01-01', 'UTC');
        $end = Date::Parse('2018-02-01', 'UTC');

        $schedule = new FakeSchedule();
        $schedule->SetAvailability($begin, $end);
        $this->scheduleRepository->_Schedule = $schedule;

        $startDate = $begin;
        $endDate = $end->AddDays(-1);

        $startDate1 = $begin->AddDays(1);
        $endDate1 = $end;

        $reservation = new TestReservationSeries();

        $dr1 = new DateRange($startDate, $endDate);
        $dr2 = new DateRange($startDate1, $endDate1);
        $reservation->WithDuration($dr1);
        $reservation->WithInstanceOn($dr2);

        $result = $this->rule->Validate($reservation, null);

        $this->assertTrue($result->IsValid());
    }

    public function testRuleIsInvalidIfFirstDateOutsideBounds()
    {
        $begin = Date::Parse('2018-01-01', 'UTC');
        $end = Date::Parse('2018-02-01', 'UTC');

        $schedule = new FakeSchedule();
        $schedule->SetAvailability($begin, $end);
        $this->scheduleRepository->_Schedule = $schedule;

        $startDate = $begin->AddDays(-1);
        $endDate = $end->AddDays(-1);

        $startDate1 = $begin->AddDays(1);
        $endDate1 = $end;

        $reservation = new TestReservationSeries();

        $dr1 = new DateRange($startDate, $endDate);
        $dr2 = new DateRange($startDate1, $endDate1);
        $reservation->WithDuration($dr1);
        $reservation->WithInstanceOn($dr2);

        $result = $this->rule->Validate($reservation, null);

        $this->assertFalse($result->IsValid());
    }

    public function testRuleIsInvalidIfLastDateOutsideBounds()
    {
        $begin = Date::Parse('2018-01-01', 'UTC');
        $end = Date::Parse('2018-02-01', 'UTC');

        $schedule = new FakeSchedule();
        $schedule->SetAvailability($begin, $end);
        $this->scheduleRepository->_Schedule = $schedule;

        $startDate = $begin;
        $endDate = $end->AddDays(-1);

        $startDate1 = $begin->AddDays(1);
        $endDate1 = $end->AddDays(1);

        $reservation = new TestReservationSeries();

        $dr1 = new DateRange($startDate, $endDate);
        $dr2 = new DateRange($startDate1, $endDate1);
        $reservation->WithDuration($dr1);
        $reservation->WithInstanceOn($dr2);

        $result = $this->rule->Validate($reservation, null);

        $this->assertFalse($result->IsValid());
    }
}