<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

require_once(ROOT_DIR . 'Controls/AnnouncementsControl.php');
require_once(ROOT_DIR . 'Controls/Dashboard/UpcomingReservations.php');

class DashboardPresenter
{
	private $_page;
	
	public function __construct(IDashboardPage $page)
	{
		$this->_page = $page;
	}
	
	public function Initialize()
	{
		$announcement = new AnnouncementsControl(new SmartyPage());
		$upcomingReservations = new UpcomingReservations(new SmartyPage());
		
		$this->_page->AddItem($announcement);
	}
}
?>