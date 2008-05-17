<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class SchedulePresenter
{
	private $_page;
	
	private $_schedules;
	
	public function __construct(ISchedulePage $page)
	{
		$this->_page = $page;
	}
	
	public function SetSchedules($schedules)
	{
		$this->_schedules = $schedules;
	}
	
	private function GetSchedules()
	{
		if (is_null($this->_schedules))
		{
			$this->_schedules = new Schedules();
		}
		
		return $this->_schedules;
	}
	
	public function PageLoad()
	{
		$this->_page->SetSchedules($this->GetSchedules()->GetAll());
	}
}
?>