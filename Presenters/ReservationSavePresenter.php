<?php 
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class ReservationSavePresenter
{
	/**
	 * @var IReservationSavePage
	 */
	private $_page;
	
	/**
	 * @var IReservationValidationFactory
	 */
	private $_validationFactory;
	
	/**
	 * @var IReservationNotificationFactory
	 */
	private $_notificationFactory;
	
	public function __construct(
		IReservationSavePage $page, 
		IReservationValidationFactory $validationFactory,
		IReservationNotificationFactory $notificationFactory)
	{
		$this->_page = $page;
		$this->_validationFactory = $validationFactory;
		$this->_notificationFactory = $notificationFactory;
	}
	
	public function PageLoad()
	{
		$reservation = GetReservation();
		
		$validationService = $this->_validationFactory->Create(ReservationAction::Create);
		$validationResult = $validationService->Validate($reservation);
		
		if ($validationResult->CanBeSaved())
		{
			ApplyReservationUpdates();
			SaveReservation();
			
			$notificationService = $this->_notificationFactory->Create(ReservationAction::Create);
			$notificationService->Notify($reservation);
			
			$this->_page->SetSaveSuccessfulMessage(true);
		}
		else
		{
			//TODO 
		}
		
		$this->_page->ShowWarnings($validationResult->GetWarnings());
	}
}

interface IReservationValidationFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @return IReservationValidationService
	 */
	function Create($reservationAction);
}

interface IReservationValidationService
{
	/**
	 * @param $reservation
	 * @return IReservationValidationResult
	 */
	function Validate($reservation);
}

interface IReservationNotificationFactory
{
	/**
	 * @param ReservationAction $reservationAction
	 * @return IReservationNotificationService
	 */
	function Create($reservationAction);
}

interface IReservationNotificationService
{
	/**
	 * @param $reservation
	 */
	function Notify($reservation);
}

interface IReservationValidationResult
{
	/**
	 * @return bool
	 */
	public function CanBeSaved();
	
	/**
	 * @return array[int]string
	 */
	public function GetErrors();
	
	/**
	 * @return array[int]string
	 */
	public function GetWarnings(); 
}

class ReservationAction
{
	const Create = 'create';
}

class ReservationValidResult implements IReservationValidationResult
{
	private $_canBeSaved;
	private $_errors;
	private $_warnings;
	
	public function __construct($canBeSaved = true, $errors = null, $warnings = null)
	{
		$this->_canBeSaved = $canBeSaved;
		$this->_errors = $errors == null ? array() : $errors;
		$this->_warnings = $warnings == null ? array() : $warnings;
	}
	
	public function CanBeSaved()
	{
		return $this->_canBeSaved;
	}
	
	public function GetErrors()
	{
		return $this->_errors;
	}
	
	public function GetWarnings()
	{
		return $this->_warnings;
	}
}
?>