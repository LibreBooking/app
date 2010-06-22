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
		
		$this->_presenter = new ReservationSavePresenter(
														$this, 
														new ReservationPersistenceFactory(),
														new ReservationValidationFactory(),
														new ReservationNotificationFactory());
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
		return $this->GetForm(FormKeys::RESERVATION_ID);
	}
	
	public function GetUserId()
	{
		return $this->GetForm(FormKeys::USER_ID);
	}
	
	public function GetResourceId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}
	
	public function GetTitle()
	{
		return $this->GetForm(FormKeys::RESERVATION_TITLE);
	}
	
	public function GetDescription()
	{
		return $this->GetForm(FormKeys::DESCRIPTION);
	}
	
	public function GetStartDate()
	{
		return $this->GetForm(FormKeys::BEGIN_DATE);
	}
	
	public function GetEndDate()
	{
		return $this->GetForm(FormKeys::END_DATE);
	}
	
	public function GetStartTime()
	{
		return $this->GetForm(FormKeys::BEGIN_PERIOD);
	}
	
	public function GetEndTime()
	{
		return $this->GetForm(FormKeys::END_PERIOD);
	}
}

interface IReservationSavePage
{
	/**
	 * @return int
	 */
	public function GetReservationId();
	
	public function GetUserId();
	public function GetResourceId();
	public function GetTitle();
	public function GetDescription();
	public function GetStartDate();
	public function GetEndDate();
	public function GetStartTime();
	public function GetEndTime();
	
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