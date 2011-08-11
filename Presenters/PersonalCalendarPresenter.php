<?php

class PersonalCalendarPresenter
{

	/**
	 * @var \IPersonalCalendarPage
	 */private $page;

	public function __construct(IPersonalCalendarPage $page)
	{
		$this->page = $page;
	}
	
	public function PageLoad($userId, $timezone)
	{
		$month = new CalendarMonth($this->page->GetMonth(), $this->page->GetYear(), $timezone);

		$this->page->Bind($month);
	}
}

?>
