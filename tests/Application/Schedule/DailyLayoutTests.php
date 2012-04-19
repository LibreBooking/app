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
		$targetTimezone = 'CST';
		
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
		$displayDate = Date::Parse('2011-03-17', 'America/Chicago');
		
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
?>