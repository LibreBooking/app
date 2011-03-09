<?php 
//require_once(ROOT_DIR . 'Pages/Ajax/ReservationUpdatePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationDeletePresenter.php');

interface IReservationDeletePage
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

class ReservationDeletePage implements IReservationDeletePage
{
	/**
	 * @var ReservationDeletePresenter
	 */
	private $_presenter;
	
	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;
	
	public function __construct()
	{
		parent::__construct();
		
//		$persistenceFactory = new ReservationPersistenceFactory();
//		$validationFactory = new ReservationValidationFactory();
//		$notificationFactory = new ReservationNotificationFactory();
//
//		$updateAction = ReservationAction::Update;
//		$userSession = ServiceLocator::GetServer()->GetUserSession();
//		
//		$this->_presenter = new ReservationUpdatePresenter(
//														$this,
//														$persistenceFactory->Create($updateAction),
//														$validationFactory->Create($updateAction, $userSession),
//														$notificationFactory->Create($updateAction)
//														);
	}
	
	public function PageLoad()
	{
//		$reservation = $this->_presenter->BuildReservation();
//		$this->_presenter->HandleReservation($reservation);

		if ($this->_reservationSavedSuccessfully)
		{
			$this->smarty->display('Ajax/reservation/delete_successful.tpl');
		}
		else
		{
			$this->smarty->display('Ajax/reservation/delete_failed.tpl');
		}
	}
	
	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->_reservationSavedSuccessfully = $succeeded;
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
?>