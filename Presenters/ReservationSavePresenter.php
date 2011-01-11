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
	 * @var IReservationPersistenceService
	 */
	private $_persistenceService;
	
	/**
	 * @var IReservationValidationService
	 */
	private $_validationService;
	
	/**
	 * @var IReservationNotificationService
	 */
	private $_notificationService;
	
	public function __construct(
		IReservationSavePage $page, 
		IReservationPersistenceService $persistenceService,
		IReservationValidationService $validationService,
		IReservationNotificationService $notificationService)
	{
		$this->_page = $page;
		$this->_persistenceService = $persistenceService;
		$this->_validationService = $validationService;
		$this->_notificationService = $notificationService;
	}
	
	public function BuildReservation()
	{
		// $reservation->AddAccessory();
		// $reservation->AddParticipant();

		// accessories?, participants, invitations
		// reminder
		
		$userId = $this->_page->GetUserId();
		$resourceId = $this->_page->GetResourceId();
		$scheduleId = $this->_page->GetScheduleId();
		$title = $this->_page->GetTitle();
		$description = $this->_page->GetDescription();
		$repeatOptions = $this->_page->GetRepeatOptions();
		$duration = $this->GetReservationDuration();
		
		$reservationSeries = ReservationSeries::Create($userId, $resourceId, $scheduleId, $title, $description, $duration, $repeatOptions);
		
		$resourceIds = $this->_page->GetResources();
		foreach ($resourceIds as $resourceId)
		{
			$reservationSeries->AddResource($resourceId);
		}
				
		return $reservationSeries;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{		
		$validationResult = $this->_validationService->Validate($reservationSeries);
		
		if ($validationResult->CanBeSaved())
		{
			try 
			{
				$this->_persistenceService->Persist($reservationSeries);
			}
			catch (Exception $ex)
			{
				Log::Error('Error saving reservation: %s', $ex);
				throw($ex);
			}
			
			$this->_notificationService->Notify($reservationSeries);
			
			$this->_page->SetReferenceNumber($reservationSeries->CurrentInstance()->ReferenceNumber());
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
		$startDate = $this->_page->GetStartDate();
		$startTime = $this->_page->GetStartTime();
		$endDate = $this->_page->GetEndDate();
		$endTime = $this->_page->GetEndTime();
		
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
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