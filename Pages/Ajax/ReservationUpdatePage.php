<?php 
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationUpdatePresenter.php');

class ReservationUpdatePage extends ReservationSavePage implements IReservationUpdatePage
{
	/**
	 * @var ReservationUpdatePresenter
	 */
	private $_presenter;
	
	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$persistenceFactory = new ReservationPersistenceFactory();
		$validationFactory = new ReservationValidationFactory();
		$notificationFactory = new ReservationNotificationFactory();

		$updateAction = ReservationAction::Update;
		
		$this->_presenter = new ReservationUpdatePresenter(
														$this,
														$persistenceFactory->Create($updateAction),
														$validationFactory->Create($updateAction),
														$notificationFactory->Create($updateAction)
														);
	}
	
	public function PageLoad()
	{
		$reservation = $this->_presenter->BuildReservation();
		$this->_presenter->HandleReservation($reservation);

		if ($this->_reservationSavedSuccessfully)
		{
			$this->smarty->display('Ajax/reservation/update_successful.tpl');
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
	
	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}
	
	public function ShowErrors($errors)
	{
		$this->Set('Errors', $errors);
	}
	
	public function ShowWarnings($warnings)
	{
		// set warnings variable
	}
	
	public function GetReservationId()
	{
		return $this->GetForm(FormKeys::RESERVATION_ID);
	}
	
	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}
}

interface IReservationUpdatePage extends IReservationSavePage
{
	/**
	 * @return int
	 */
	public function GetReservationId();
	
	/**
	 * @return SeriesUpdateScope
	 */
	public function GetSeriesUpdateScope();
}
?>