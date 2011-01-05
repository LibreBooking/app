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

class ReservationSavePresenter
{
	/**
	 * @var IReservationSavePage
	 */
	private $_page;
	
	/**
	 * @var IReservationPersistenceFactory
	 */
	private $_persistenceFactory;
	
	/**
	 * @var IReservationValidationFactory
	 */
	private $_validationFactory;
	
	/**
	 * @var IReservationNotificationFactory
	 */
	private $_notificationFactory;
	
	/**
	 * @var DateRange
	 */
	private $duration;
	
	public function __construct(
		IReservationSavePage $page, 
		IReservationPersistenceFactory $persistenceFactory,
		IReservationValidationFactory $validationFactory,
		IReservationNotificationFactory $notificationFactory)
	{
		$this->_page = $page;
		$this->_persistenceFactory = $persistenceFactory;
		$this->_validationFactory = $validationFactory;
		$this->_notificationFactory = $notificationFactory;
	}
	
	public function BuildReservation()
	{
//		$reservation->AddAccessory();
//		$reservation->AddParticipant();
//		
//		$reservation->RemoveResource();
//		$reservation->RemoveAccessory();
//		$reservation->RemoveParticipant();

		$action = $this->_page->GetReservationAction();
		$reservationId = $this->_page->GetReservationId();	
		$persistenceService = $this->_persistenceFactory->Create($action);
		$reservationSeries = $persistenceService->Load($reservationId);
		
		// accessories?, participants, invitations
		// reminder

		$reservationSeries = ReservationSeries::Create();
		
		$userId = $this->_page->GetUserId();
		$resourceId = $this->_page->GetResourceId();
		$scheduleId = $this->_page->GetScheduleId();
		$title = $this->_page->GetTitle();
		$description = $this->_page->GetDescription();

		$reservationSeries->Update(
			$userId, 
			$resourceId, 
			$scheduleId,
			$title,
			$description);
		
		$duration = $this->GetReservationDuration();
		$reservationSeries->UpdateDuration($duration);
		
		$repeatOptions = $this->_page->GetRepeatOptions($duration);
		$reservationSeries->Repeats($repeatOptions);
		
		$resourceIds = $this->_page->GetResources();
		foreach ($resourceIds as $resourceId)
		{
			$reservationSeries->AddResource($resourceId);
		}
		
		$seriesUpdateScope = $this->_page->GetSeriesUpdateScope();
		
		if ($action == ReservationAction::Update)
		{
			$reservationSeries->ApplyChangesTo($seriesUpdateScope);
		}
		
		return $reservationSeries;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{		
		$action = $this->_page->GetReservationAction();
		
		$validationService = $this->_validationFactory->Create($action);
		$validationResult = $validationService->Validate($reservationSeries);
		
		if ($validationResult->CanBeSaved())
		{
			$persistenceService = $this->_persistenceFactory->Create($action);
			
			try 
			{
				$persistenceService->Persist($reservationSeries);
			}
			catch (Exception $ex)
			{
				Log::Error('Error saving reservation: %s', $ex);
				throw($ex);
			}
			
			$notificationService = $this->_notificationFactory->Create($action);
			$notificationService->Notify($reservationSeries);
			
			$duration = $this->GetReservationDuration();
			
			$this->_page->SetReferenceNumber($reservationSeries->GetInstance($duration->GetBegin())->ReferenceNumber());
			$this->_page->SetSaveSuccessfulMessage(true);
		}
		else
		{
			$this->_page->SetSaveSuccessfulMessage(false);
			$this->_page->ShowErrors($validationResult->GetErrors());
		}
		
		$this->_page->ShowWarnings($validationResult->GetWarnings());
	}
	
	/**
	 * @return DateRange
	 */
	private function GetReservationDuration()
	{
		if ($this->duration == null)
		{
			$startDate = $this->_page->GetStartDate();
			$startTime = $this->_page->GetStartTime();
			$endDate = $this->_page->GetEndDate();
			$endTime = $this->_page->GetEndTime();
			
			$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
			$this->duration = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
		}
		
		return $this->duration;
	}
	
	/**s
	 * @return IRepeatOptions
	 */
	public function GetRepeatOptions()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$factory = new RepeatOptionsFactory();
		
		$repeatType = $this->_page->GetRepeatType();
		$interval = $this->_page->GetRepeatInterval();
		$weekdays = $this->_page->GetRepeatWeekdays();
		$monthlyType = $this->_page->GetRepeatMonthlyType();
		$terminationDate = Date::Parse($this->_page->GetRepeatTerminationDate(), $timezone);
		
		return $factory->Create($repeatType, $interval, $terminationDate, $weekdays, $monthlyType);
	}
}
?>