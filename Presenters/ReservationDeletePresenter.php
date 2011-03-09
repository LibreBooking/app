<?php
class ReservationDeletePresenter
{
	/**
	 * @var IReservationDeletePage
	 */
	private $page;
	
	/**
	 * @var IUpdateReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IUpdateReservationValidationService
	 */
	private $validationService;
	
	/**
	 * @var IUpdateReservationNotificationService
	 */
	private $notificationService;
	
	public function __construct(
		IReservationDeletePage $page, 
		IUpdateReservationPersistenceService $persistenceService,
		IUpdateReservationValidationService $validationService,
		IUpdateReservationNotificationService $notificationService)
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
		
		// $existingSeries->Delete();
		
		return $existingSeries;
	}
	
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{		
		$validationResult = $this->validationService->Validate($reservationSeries);
		
		if ($validationResult->CanBeSaved())
		{
			try 
			{
				$this->persistenceService->Persist($reservationSeries);
			}
			catch (Exception $ex)
			{
				Log::Error('Error saving reservation: %s', $ex);
				throw($ex);
			}
			
			$this->notificationService->Notify($reservationSeries);
			
			$this->page->SetSaveSuccessfulMessage(true);
		}
		else
		{
			$this->page->SetSaveSuccessfulMessage(false);
			$this->page->ShowErrors($validationResult->GetErrors());
		}
		
		$this->page->ShowWarnings($validationResult->GetWarnings());
	}
}
?>