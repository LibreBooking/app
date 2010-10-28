<?php
require_once('Language.php');
require_once('en_us.php');

class en_gb extends en_us
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function _LoadDates()
	{
		$dates = array();
		
		// General date formatting used for all date display unless otherwise noted
		$dates['general_date'] = '%m/%d/%Y';
		// General datetime formatting used for all datetime display unless otherwise noted
		// The hour:minute:second will always follow this format
		$dates['general_datetime'] = '%m/%d/%Y @';
		// Date in the reservation notification popup and email
		$dates['res_check'] = '%A %m/%d/%Y';
		// Date on the scheduler that appears above the resource links
		$dates['schedule_daily'] = '%A,<br/>%m/%d/%Y';
		// Date on top-right of each page
		$dates['header'] = '%A, %B %d, %Y';
		
		// new stuff
		$dates['js_general_date'] = 'mm/dd/yy';
		$dates['general_date'] = 'm/d/Y';
		$dates['schedule_daily'] = 'l, m/d/Y';
		$dates['period_time'] = "g:i A";
		$dates['url'] = 'Y-m-d';
		$dates['reservation_email'] = 'm/d/Y @ g:i A (e)';
		
		$this->Dates = $dates;
	}
}
?>