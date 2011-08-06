<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Persistence/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ReservationHandler.php');

class ReservationDeletePresenter
{
	/**
	 * @var IReservationDeletePage
	 */
	private $page;
	
	/**
	 * @var IDeleteReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IDeleteReservationValidationService
	 */
	private $validationService;
	
	/**
	 * @var IDeleteReservationNotificationService
	 */
	private $notificationService;
	
	public function __construct(
		IReservationDeletePage $page, 
		IDeleteReservationPersistenceService $persistenceService,
		IDeleteReservationValidationService $validationService,
		IDeleteReservationNotificationService $notificationService)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->validationService = $validationService;
		$this->notificationService = $notificationService;
	}
	
	/**
	 * @return ExistingReservationSeries 
	 */
	public function BuildReservation()
	{
		$instanceId = $this->page->GetReservationId();
		$existingSeries = $this->persistenceService->LoadByInstanceId($instanceId);
		$existingSeries->ApplyChangesTo($this->page->GetSeriesUpdateScope());
		
		$existingSeries->Delete();
		
		return $existingSeries;
	}
	
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{		
		$handler = new ReservationHandler();
		$handler->Handle(
			$reservationSeries,
			$this->page,
			$this->persistenceService,
			$this->validationService,
			$this->notificationService);
	}
}
?>