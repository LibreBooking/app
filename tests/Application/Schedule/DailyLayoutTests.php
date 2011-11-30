<?php 
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
		$dateListing = $this->getMock('IDateReservationListing');
		$resourceListing = $this->getMock('IResourceReservationListing');
		
		$startDate = Date::Parse('2009-09-02 17:00:00', 'UTC');
		$endDate = Date::Parse('2009-09-02 18:00:00', 'UTC');
		$reservation = new TestReservationListItem($startDate, $endDate, $resourceId);
		$reservations = array($reservation);		

		$listing->expects($this->once())
			->method('OnDate')
			->with($this->equalTo($date))
			->will($this->returnValue($dateListing));
			
		$dateListing->expects($this->once())
			->method('ForResource')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resourceListing));
		
		$resourceListing->expects($this->once())
			->method('Reservations')
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
		
		$layout = new DailyLayout(new ReservationListing(), $scheduleLayout);
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