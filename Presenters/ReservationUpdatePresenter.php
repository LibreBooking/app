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
	 * @var IUpdateReservationValidationService
	 */
	private $validationService;
	
	/**
	 * @var IUpdateReservationNotificationService
	 */
	private $notificationService;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;
	
	public function __construct(
		IReservationUpdatePage $page, 
		IUpdateReservationPersistenceService $persistenceService,
		IUpdateReservationValidationService $validationService,
		IUpdateReservationNotificationService $notificationService,
		IResourceRepository $resourceRepository)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->validationService = $validationService;
		$this->notificationService = $notificationService;
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

		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
		$existingSeries->Update(
			$this->page->GetUserId(), 
			$resource,
			$this->page->GetTitle(), 
			$this->page->GetDescription(),
			ServiceLocator::GetServer()->GetUserSession());
		
		$existingSeries->Repeats($this->page->GetRepeatOptions());

		$additionalResources = array();
		foreach ($this->page->GetResources() as $additionalResourceId)
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
		$handler = new ReservationHandler();
		
		$successfullySaved = $handler->Handle(
							$reservationSeries,
							$this->page, 
							$this->persistenceService, 
							$this->validationService, 
							$this->notificationService);
		
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