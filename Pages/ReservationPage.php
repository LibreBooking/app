<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
//require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

class ReservationPage extends Page implements IReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');
		
		//$this->_presenter = new SchedulePresenter($this, $scheduleRepository, $resourceService, $pageBuilder, $permissionServiceFactory, $reservationService, $dailyLayoutFactory);
	}
	
	public function PageLoad()
	{
		//$this->_presenter->PageLoad();
		$this->smarty->display('reservation.tpl');		
	}
}

interface IReservationPage
{
	
}
?>