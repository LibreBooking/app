<?php
require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/Dashboard/UpcomingReservationsPresenter.php');

class UpcomingReservations extends DashboardItem implements IUpcomingReservationsControl
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
	
	public function BindReservations($reservations)
	{
		$this->Assign('UpcomingReservations', $reservations);
	}
}

interface IUpcomingReservationsControl
{
	function BindReservations($reservations);
}


?>