<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class CalendarPresenter
{
	private $_page;
	
	public function __construct(ICalendarPage $page)
	{
		$this->_page = $page;
	}
	
	public function PageLoad()
	{
	}
}
?>