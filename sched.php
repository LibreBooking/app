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
		$resources[] = new ResourceDto(1, 'Meeting Room 1', true);
		$resources[] = new ResourceDto(2, 'Compuer Lab', true);
		$resources[] = new ResourceDto(3, 'Cytrometer', false);
		
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
		
		//$layout->AppendBlockedPeriod(Time::Parse('0:00', $tz), Time::Parse('1:00', $tz), 'label1');
		//$layout->AppendBlockedPeriod(Time::Parse('1:00', $tz), Time::Parse('2:00', $tz), 'label2');
		//$layout->AppendBlockedPeriod(Time::Parse('2:00', $tz), Time::Parse('3:00', $tz), 'label3');
		
		for ($i = 3; $i < 21; $i++)
		{
			$start = $i;
			$end = $i + 1;
			$layout->AppendPeriod(Time::Parse("$start:00", $tz), Time::Parse("$end:00", $tz));
		}
		
		//$layout->AppendBlockedPeriod(Time::Parse('22:00', $tz), Time::Parse('23:00', $tz));
		//$layout->AppendBlockedPeriod(Time::Parse('23:00', $tz), Time::Parse('24:00', $tz));

		return $layout;
	}
	
	private function GetReservationListing()
	{
		$listing = new ReservationListing();
		
		$t1 = Time::Parse('3:00', 'UTC');
		$t2 = Time::Parse('6:00', 'UTC');
		$today = Date::Now()->Format('Y-m-d');
		$d1 = Date::Parse($today . $t1->ToString(), 'UTC');
		$d2 = Date::Parse($today . $t2->ToString(), 'UTC');
		
		//echo 'res date: ' . $d1 . ' ' . $d2;
		
		$res = new ScheduleReservation(1, $d1, $d2, 1, 'some summary', null, 2, 1, 'nick', 'korbel');
		
		//echo 'res date: ' . $res->GetStartDate() . ' ' . $d2;
		
		$listing->Add($d1, $d2, $res);
		
		return $listing;
		
	}
}

$page = new SchedulePage();
$page->PageLoad();

?>