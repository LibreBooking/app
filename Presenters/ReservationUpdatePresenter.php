<?php
require_once(ROOT_DIR . 'Presenters/ReservationHandler.php');

class ReservationUpdatePresenter
{
	/**
	 * @var IReservationUpdatePage
	 */
	private $page;
	
	/**
	 * @var UpdateReservationPersistenceService
	 */
	private $persistenceService;
	
	/**
	 * @var IReservationHandler
	 */
	private $handler;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;
	
	public function __construct(
		IReservationUpdatePage $page, 
		IUpdateReservationPersistenceService $persistenceService,
		IReservationHandler $handler,
		IResourceRepository $resourceRepository)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
		$this->resourceRepository = $resourceRepository;
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

		$resourceId = $this->page->GetResourceId();
		$additionalResourceIds = $this->page->GetResources();
		
		if (empty($resourceId))
		{
			// the first additional resource will become the primary if the primary is removed
			$resourceId = array_shift($additionalResourceIds);
		}
		
		$resource = $this->resourceRepository->LoadById($resourceId);
		$existingSeries->Update(
			$this->page->GetUserId(), 
			$resource,
			$this->page->GetTitle(), 
			$this->page->GetDescription(),
			ServiceLocator::GetServer()->GetUserSession());
		
		$existingSeries->Repeats($this->page->GetRepeatOptions());

		$additionalResources = array();
		foreach ($additionalResourceIds as $additionalResourceId)
		{
			$additionalResources[] = $this->resourceRepository->LoadById($additionalResourceId);
		}
		$existingSeries->ChangeResources($additionalResources);

		$existingSeries->ChangeParticipants($this->page->GetParticipants());
		$existingSeries->ChangeInvitees($this->page->GetInvitees());

		return $existingSeries;
	}
	
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{		
		$successfullySaved = $this->handler->Handle($reservationSeries,	$this->page);
		
		if ($successfullySaved)
		{
			$this->page->SetReferenceNumber($reservationSeries->CurrentInstance()->ReferenceNumber());
		}
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