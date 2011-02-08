<?php
class ReservationUpdatePresenter
{
	/**
	 * @var IReservationUpdatePage
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
		IReservationUpdatePage $page, 
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
		$existingSeries->UpdateDuration($this->GetReservationDuration());

		$existingSeries->Update(
			$this->page->GetUserId(), 
			$this->page->GetResourceId(), 
			$this->page->GetTitle(), 
			$this->page->GetDescription());
		
		$existingSeries->Repeats($this->page->GetRepeatOptions());
		
		foreach ($this->page->GetResources() as $resourceId)
		{
			$existingSeries->AddResource($resourceId);
		}
		
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
			
			$this->page->SetReferenceNumber($reservationSeries->CurrentInstance()->ReferenceNumber());
			$this->page->SetSaveSuccessfulMessage(true);
		}
		else
		{
			$this->page->SetSaveSuccessfulMessage(false);
			$this->page->ShowErrors($validationResult->GetErrors());
		}
		
		$this->page->ShowWarnings($validationResult->GetWarnings());
	}
	
	/**
	 * @return DateRange
	 */
	private function GetReservationDuration()
	{
		$startDate = $this->page->GetStartDate();
		$startTime = $this->page->GetStartTime();
		$endDate = $this->page->GetEndDate();
		$endTime = $this->page->GetEndTime();
		
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
	}
}
?>