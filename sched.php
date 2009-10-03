<?php
define('ROOT_DIR', './');

require_once(ROOT_DIR . '/Pages/SchedulePage.php');

class MockSchedulePresenter implements ISchedulePresenter
{
	/**
	 * @var ISchedulePage
	 */
	private $_page;
	
	public function __construct(ISchedulePage $page)
	{
		$this->_page = $page;
	}
	
	public function PageLoad()
	{
		$s1 = new Schedule(1, 'schedule1', true, 0, 0, 0, 0, 0);
		$schedules = array($s1);
		$this->_page->SetSchedules($schedules);
		$this->_page->SetDisplayDates(new DateRange(Date::Now(), Date::Now()->AddDays(7)));
		$this->_page->SetDailyLayout($this->GetReservations());
		$this->_page->SetResources($this->GetResources());
		$this->_page->SetLayout($this->GetLayout());
	}
	
	private function GetResources()
	{
		$resources[] = new ResourceDto(1, 'res1', true);
		$resources[] = new ResourceDto(2, 'res2', true);
		$resources[] = new ResourceDto(3, 'res3', false);
		
		return $resources;
	}
	
	private function GetReservations()
	{
		return new DailyLayout($this->GetReservationListing(), $this->GetLayout(), 'US/Central');
	}
	
	private function GetLayout()
	{
		$tz = 'UTC';
		$layout = new ScheduleLayout('US/Central');
		
		$layout->AppendPeriod(Time::Parse('5:00', $tz), Time::Parse('15:00', $tz), 'label1');
		$layout->AppendPeriod(Time::Parse('15:00', $tz), Time::Parse('18:00', $tz));

		return $layout;
	}
	
	private function GetReservationListing()
	{
		$listing = new ReservationListing();
		
		$t1 = Time::Parse('5:00', 'UTC');
		$t2 = Time::Parse('18:00', 'UTC');
		$d1 = Date::Parse('2009-10-03' . $t1->ToString(), 'UTC');
		$d2 = Date::Parse('2009-10-03' . $t2->ToString(), 'UTC');
		
		//echo 'res date: ' . $d1 . ' ' . $d2;
		
		$res = new ScheduleReservation(1, $d1, $d2, 1, 'some summary', null, 2, 1, 'nick', 'korbel');
		
		//echo 'res date: ' . $res->GetStartDate() . ' ' . $d2;
		
		$listing->Add($d1->ToTimezone('US/Central'), $d2->ToTimezone('US/Central'), $res);
		
		return $listing;
		
	}
}

$page = new SchedulePage();
$page->PageLoad();

?>