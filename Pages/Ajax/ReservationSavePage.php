<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationSavePresenter.php');

class ReservationSavePage extends Page implements IReservationSavePage
{
	/**
	 * @var ReservationSavePresenter
	 */
	private $_presenter;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_presenter = new ReservationSavePresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		// do we want a save/update/deleted successful?
		if ($this->ReservationSavedSuccessfully)
		{
			$this->smarty->display('Ajax/reservation/savesuccessful.tpl');
		}
		else
		{
			$this->smarty->display('Ajax/reservation/savefailed.tpl');
		}
	}
}

interface IReservationSavePage
{}
?>