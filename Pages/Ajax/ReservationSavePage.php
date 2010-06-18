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
	
	public function ShowErrors($errors)
	{
		// set errors variable
	}
	
	public function ShowWarnings($warnings)
	{
		// set warnings variable
	}
	
	public function GetReservationId()
	{
		return $this->server->GetForm(FormKeys::RESERVATION_ID);
	}
}

interface IReservationSavePage
{
	/**
	 * @return int
	 */
	public function GetReservationId();
	
	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded);
	
	/**
	 * @param array[int]string $errors
	 */
	public function ShowErrors($errors);
	
	/**
	 * @param array[int]string $warnings
	 */
	public function ShowWarnings($warnings);
}
?>