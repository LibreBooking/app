<?php
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
	 * @var IReservationHandler
	 */
	private $handler;
	
	public function __construct(
		IReservationDeletePage $page, 
		IDeleteReservationPersistenceService $persistenceService,
		IReservationHandler $handler)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
	}
	
	/**
	 * @return ExistingReservationSeries 
	 */
	public function BuildReservation()
	{
		$instanceId = $this->page->GetReservationId();
		$existingSeries = $this->persistenceService->LoadByInstanceId($instanceId);
		$existingSeries->ApplyChangesTo($this->page->GetSeriesUpdateScope());
		
		$existingSeries->Delete(ServiceLocator::GetServer()->GetUserSession());
		
		return $existingSeries;
	}
	
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{
		Log::Debug("Deleting reservation %s", $reservationSeries->CurrentInstance()->ReferenceNumber());
	
		$this->handler->Handle($reservationSeries, $this->page);
	}
}
?>