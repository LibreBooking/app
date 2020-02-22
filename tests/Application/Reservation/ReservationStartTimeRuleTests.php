<?php
/**
Copyright 2011-2020 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationStartTimeRuleTests extends TestBase
{
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var IScheduleLayout
     */
    private $layout;

	public function setUp(): void
	{
		parent::setup();
        $this->scheduleRepository = $this->createMock('IScheduleRepository');
        $this->layout = $this->createMock('IScheduleLayout');

        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::FUTURE);
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testRuleIsValidStartTimeIsNow()
	{
		$start = Date::Now();
		$end = Date::Now()->AddDays(1);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));

		$rule = new ReservationStartTimeRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsValidIfStartTimeIsInFuture()
	{
		$start = Date::Now()->AddDays(1);
		$end = Date::Now()->AddDays(2);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));

		$rule = new ReservationStartTimeRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsInvalidIfStartIsInPast()
	{
		$start = Date::Now()->AddDays(-2);
		$end = Date::Now()->AddDays(-1);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));

		$rule = new ReservationStartTimeRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

	public function testRuleIsInvalidIfStartTimeIsInPast()
	{
		$now = Date::Parse('2011-04-04 12:13:15', 'UTC');
		Date::_SetNow($now);
		$start = Date::Parse('2011-04-04 12:13:14', 'UTC');
		$end = $start->AddDays(5);

		$reservation = new TestReservationSeries();
		$reservation->WithCurrentInstance(new TestReservation('1', new DateRange($start, $end)));

		$rule = new ReservationStartTimeRule($this->scheduleRepository);
		$result = $rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}

    public function testWhenAllowedToWorkWithCurrentSlot()
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::CURRENT);

        $scheduleId = 123;
        $now = Date::Parse('2011-04-04 12:13:15', 'UTC');
        Date::_SetNow($now);

        $start = $now->AddDays(-5);
        $end = $now->AddDays(5);

        $periodStart =  Date::Parse('2011-04-04 12:13:16', 'UTC');
        $periodEnd = Date::Parse('2011-04-04 12:13:17', 'UTC');

        $reservation = new TestReservationSeries();
        $reservation->WithScheduleId($scheduleId);
        $reservation->WithCurrentInstance(new TestReservation('1',new DateRange($start, $end)));

        $this->scheduleRepository->expects($this->once())
            ->method('GetLayout')
            ->with($this->equalTo($scheduleId), $this->equalTo(new ScheduleLayoutFactory('UTC')))
            ->will($this->returnValue($this->layout));

        $period = new SchedulePeriod($periodStart, $periodEnd);
        $this->layout->expects($this->once())
                ->method('GetPeriod')
                ->with($this->equalTo($end))
                ->will($this->returnValue($period));


        $rule = new ReservationStartTimeRule($this->scheduleRepository);
        $result = $rule->Validate($reservation, null);

        $this->assertTrue($result->IsValid());
    }

    public function testWhenPeriodStartTimeIsInPast()
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::CURRENT);

        $scheduleId = 123;
        $now = Date::Parse('2011-04-04 12:13:15', 'UTC');
        Date::_SetNow($now);

        $start = $now->AddDays(-5);
        $end = $now->AddDays(5);

        $periodStart = Date::Parse('2011-04-04 12:13:14', 'UTC');
        $periodEnd = Date::Parse('2011-04-04 12:13:16', 'UTC');

        $reservation = new TestReservationSeries();
        $reservation->WithScheduleId($scheduleId);
        $reservation->WithCurrentInstance(new TestReservation('1',new DateRange($start, $end)));

        $this->scheduleRepository->expects($this->once())
            ->method('GetLayout')
            ->with($this->equalTo($scheduleId), $this->equalTo(new ScheduleLayoutFactory('UTC')))
            ->will($this->returnValue($this->layout));

        $period = new SchedulePeriod($periodStart, $periodEnd);
        $this->layout->expects($this->once())
                ->method('GetPeriod')
                ->with($this->equalTo($end))
                ->will($this->returnValue($period));


        $rule = new ReservationStartTimeRule($this->scheduleRepository);
        $result = $rule->Validate($reservation, null);

        $this->assertFalse($result->IsValid());
    }

    public function testWhenNotConstrainedByTime()
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::NONE);
        $now = Date::Parse('2011-04-04 12:13:15', 'UTC');
        Date::_SetNow($now);
        $start = Date::Parse('2011-04-04 12:13:14', 'UTC');
        $end = $start->AddDays(5);

        $reservation = new TestReservationSeries();
        $reservation->WithCurrentInstance(new TestReservation('1',new DateRange($start, $end)));

        $rule = new ReservationStartTimeRule($this->scheduleRepository);
        $result = $rule->Validate($reservation, null);

       	$this->assertTrue($result->IsValid());
    }
}

?>