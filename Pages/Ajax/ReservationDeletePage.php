<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsPage.php');
require_once(ROOT_DIR . 'Presenters/ReservationDeletePresenter.php');

interface IReservationDeletePage extends IReservationSaveResultsPage
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

class ReservationDeletePage extends SecurePage implements IReservationDeletePage
{
	/**
	 * @var ReservationDeletePresenter
	 */
	private $presenter;
	
	/**
	 * @var bool
	 */
	private $reservationSavedSuccessfully = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$persistenceFactory = new ReservationPersistenceFactory();
		$validationFactory = new ReservationValidationFactory();
		$notificationFactory = new ReservationNotificationFactory();

		$updateAction = ReservationAction::Delete;
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		
		$this->presenter = new ReservationDeletePresenter(
														$this,
														$persistenceFactory->Create($updateAction),
														$validationFactory->Create($updateAction, $userSession),
														$notificationFactory->Create($updateAction)
														);
	}
	
	public function PageLoad()
	{
		$reservation = $this->presenter->BuildReservation();
		$this->presenter->HandleReservation($reservation);

		if ($this->reservationSavedSuccessfully)
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
		$this->reservationSavedSuccessfully = $succeeded;
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