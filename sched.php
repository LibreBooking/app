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
		$schedules = array();
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
		return new DailyLayout(new ReservationListing(), $this->GetLayout(), 'CST');
	}
	
	private function GetLayout()
	{
		$tz = 'UTC';
		$layout = new ScheduleLayout($tz);
		
		$layout->AppendPeriod(Time::Parse('5:00', $tz), Time::Parse('15:00', $tz), 'label1');
		$layout->AppendPeriod(Time::Parse('16:00', $tz), Time::Parse('18:00', $tz), 'label2');

		return $layout;
	}
}

$page = new SchedulePage();
$page->PageLoad();

?>