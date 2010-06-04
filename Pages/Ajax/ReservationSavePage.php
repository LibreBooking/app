<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationSavePresenter.php');

class ReservationSavePage extends Page implements IReservationSavePage
{
	/**
	 * @var ReservationSavePresenter
	 */
	private $_presenter;
	
	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_presenter = new ReservationSavePresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		
		// do we want a save/update/deleted successful?
		if ($this->_reservationSavedSuccessfully)
		{
			$this->smarty->display('Ajax/reservation/savesuccessful.tpl');
		}
		else
		{
			$this->smarty->display('Ajax/reservation/savefailed.tpl');
		}
	}
	
	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->_reservationSavedSuccessfully = $succeeded;
	}
}

interface IReservationSavePage
{
	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded);
}
?>