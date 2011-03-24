<?php
require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
//require_once(ROOT_DIR . 'Presenters/AnnouncementPresenter.php');

class UpcomingReservations extends DashboardItem
{
	public function __construct(SmartyPage $smarty)
	{
		// should this be a Page instead?
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
	}
}


?>