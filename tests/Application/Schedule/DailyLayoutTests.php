<?php
/**
 * Copyright 2011-2019 Nick Korbel
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

require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class DailyLayoutTests extends TestBase
{
    public function setup()
    {
        parent::setup();
    }

    public function teardown()
    {
        parent::teardown();
    }

    public function testGetLayoutReturnsBuiltSlotsFromScheduleReservationList()
    {
        $date = Date::Parse('2009-09-02', 'UTC');
        $resourceId = 1;
        $targetTimezone = 'America/Chicago';

        $scheduleLayout = new ScheduleLayout($targetTimezone);
        $scheduleLayout->AppendPeriod(new Time(5, 0, 0, $targetTimezone), new Time(6, 0, 0, $targetTimezone));

        $listing = $this->getMock('IReservationListing');

        $startDate = Date::Parse('2009-09-02 17:00:00', 'UTC');
        $endDate = Date::Parse('2009-09-02 18:00:00', 'UTC');
        $reservation = new TestReservationListItem($startDate, $endDate, $resourceId);
        $reservations = array($reservation);

        $listing->expects($this->once())
            ->method('OnDateForResource')
            ->with($this->equalTo($date), $this->equalTo($resourceId))
            ->will($this->returnValue($reservations));

        $layout = new DailyLayout($listing, $scheduleLayout);
        $layoutSlots = $layout->GetLayout($date, $resourceId);

        $reservationList = new ScheduleReservationList($reservations, $scheduleLayout, $date);
        $expectedSlots = $reservationList->BuildSlots();

        $this->assertEquals($expectedSlots, $layoutSlots);
    }

    public function testCanGetDisplayLabelsForDate()
    {
        $this->fakeResources->SetDateFormat('period_time', 'h:i');
        $displayDate = Date::Parse('2010-03-17', 'America/Chicago');

        $periods[] = new SchedulePeriod(Date::Parse('2010-03-16 20:30'), Date::Parse('2010-03-17 12:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 12:30'), Date::Parse('2010-03-17 20:30'), "start", "end");
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 20:30'), Date::Parse('2010-03-18 12:30'));

        $scheduleLayout = $this->getMock('IScheduleLayout');
        $scheduleLayout->expects($this->once())
            ->method('GetLayout')
            ->with($this->equalTo($displayDate))
            ->will($this->returnValue($periods));

        $layout = new DailyLayout(new ReservationListing("America/Chicago"), $scheduleLayout);
        $labels = $layout->GetLabels($displayDate);

        $this->assertEquals('12:00', $labels[0]);
        $this->assertEquals('start', $labels[1]);
        $this->assertEquals('08:30', $labels[2]);
    }

    public function testGetsLayoutWithHourIndications()
    {
        $this->fakeResources->SetDateFormat('period_time', 'h:i');
        $displayDate = Date::Parse('2010-03-17', 'America/Chicago');

        $periods[] = new SchedulePeriod(Date::Parse('2010-03-16 20:30'), Date::Parse('2010-03-17 6:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 6:30'), Date::Parse('2010-03-17 7:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 7:30'), Date::Parse('2010-03-17 8:00'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 8:00'), Date::Parse('2010-03-17 8:15'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 8:15'), Date::Parse('2010-03-17 8:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 8:30'), Date::Parse('2010-03-17 8:45'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 8:45'), Date::Parse('2010-03-17 9:00'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 9:00'), Date::Parse('2010-03-17 9:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 9:30'), Date::Parse('2010-03-17 10:00'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 10:00'), Date::Parse('2010-03-17 11:00'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 11:00'), Date::Parse('2010-03-17 11:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 11:30'), Date::Parse('2010-03-17 14:00'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 14:00'), Date::Parse('2010-03-18 17:30'));
        $periods[] = new SchedulePeriod(Date::Parse('2010-03-17 17:30'), Date::Parse('2010-03-18 8:30'));

        $scheduleLayout = $this->getMock('IScheduleLayout');
        $scheduleLayout->expects($this->once())
            ->method('GetLayout')
            ->with($this->equalTo($displayDate))
            ->will($this->returnValue($periods));

        $scheduleLayout->expects($this->once())
            ->method('FitsToHours')
            ->will($this->returnValue(true));

        $layout = new DailyLayout(new ReservationListing("America/Chicago"), $scheduleLayout);
        $labels = $layout->GetPeriods($displayDate, true);

        $i = 0;
        $this->assertEquals('12:00', $labels[$i]->Label($displayDate));
        $this->assertEquals(1, $labels[$i]->Span());
        $i++;
        $this->assertEquals('06:30', $labels[$i]->Label($displayDate));
        $this->assertEquals(1, $labels[$i]->Span());
        $i++;
        $this->assertEquals('07:30', $labels[$i]->Label($displayDate));
        $this->assertEquals(1, $labels[$i]->Span());
        $i++;
        $this->assertEquals('08:00', $labels[$i]->Label($displayDate));
        $this->assertEquals(4, $labels[$i]->Span());
        $i++;
        $this->assertEquals('09:00', $labels[$i]->Label($displayDate));
        $this->assertEquals(2, $labels[$i]->Span());
        $i++;
        $this->assertEquals('10:00', $labels[$i]->Label($displayDate));
        $this->assertEquals(1, $labels[$i]->Span());
        $i++;
        $this->assertEquals('11:00', $labels[$i]->Label($displayDate));
        $this->assertEquals(2, $labels[$i]->Span());
        $i++;
        $this->assertEquals('02:00', $labels[$i]->Label($displayDate));
        $this->assertEquals(1, $labels[$i]->Span());
        $i++;
        $this->assertEquals('05:30', $labels[$i]->Label($displayDate));
        $this->assertEquals(1, $labels[$i]->Span());
    }

    public function testGetsDailySummaryForResource()
    {
        $targetTimezone = 'America/Chicago';
        $date = Date::Parse('2009-09-02', $targetTimezone);
        $start = $date->SetTime(Time::Parse('04:00'));
        $end = $date->SetTime(Time::Parse('05:00'));
        $resourceId = 1;

        $scheduleLayout = new ScheduleLayout($targetTimezone);
        $scheduleLayout->AppendPeriod(new Time(4, 0, 0, $targetTimezone), new Time(5, 0, 0, $targetTimezone));

        $listing = $this->getMock('IReservationListing');

        $firstReservation = new TestReservationListItem($start, $end, $resourceId);
        $reservations = array(
            $firstReservation,
            new TestReservationListItem($start, $end, $resourceId),
            new TestBlackoutListItem($start, $end, $resourceId),
        );

        $listing->expects($this->once())
            ->method('OnDateForResource')
            ->with($this->equalTo($date), $this->equalTo($resourceId))
            ->will($this->returnValue($reservations));

        $layout = new DailyLayout($listing, $scheduleLayout);
        $summary = $layout->GetSummary($date, $resourceId);

        $this->assertEquals(2, $summary->NumberOfReservations());
        $this->assertEquals($firstReservation, $summary->FirstReservation());
    }
}

class TestReservationListItem extends ReservationListItem
{
    /**
     * @var \Date
     */
    private $start;

    /**
     * @var \Date
     */
    private $end;

    /**
     * @var int
     */
    private $resourceId;

    public function __construct(Date $start, Date $end, $resourceId)
    {
        $this->start = $start;
        $this->end = $end;
        $this->resourceId = $resourceId;

        parent::__construct(new TestReservationItemView(1, $start, $end, $resourceId));
    }

    public function StartDate()
    {
        return $this->start;
    }

    public function EndDate()
    {
        return $this->end;
    }

    public function ResourceId()
    {
        return $this->resourceId;
    }
}

class TestBlackoutListItem extends BlackoutListItem
{
    /**
     * @var \Date
     */
    private $start;

    /**
     * @var \Date
     */
    private $end;

    /**
     * @var int
     */
    private $resourceId;

    public function __construct(Date $start, Date $end, $resourceId)
    {
        $this->start = $start;
        $this->end = $end;
        $this->resourceId = $resourceId;

        parent::__construct(new TestBlackoutItemView(1, $start, $end, $resourceId));
    }

    public function StartDate()
    {
        return $this->start;
    }

    public function EndDate()
    {
        return $this->end;
    }

    public function ResourceId()
    {
        return $this->resourceId;
    }
}

?>