<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');

class ExistingReservationInitializer extends ReservationInitializerBase
{
	/**
	 * @var IExistingReservationPage
	 */
	private $page;
	
	/**
	 * @var ReservationView 
	 */
	private $reservationView;
	
	
	public function __construct(
		IExistingReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		ReservationView $reservationView
		)
	{
		$this->page = $page;
		$this->reservationView = $reservationView;
		
		parent::__construct(
						$page, 
						$scheduleUserRepository, 
						$scheduleRepository, 
						$userRepository);
	}
	
	public function Initialize()
	{
		parent::Initialize();
		
		$this->page->SetAdditionalResources($this->reservationView->AdditionalResourceIds);
		$this->page->SetParticipants($this->reservationView->ParticipantIds);
		$this->page->SetTitle($this->reservationView->Title);
		$this->page->SetDescription($this->reservationView->Description);
		$this->page->SetReferenceNumber($this->reservationView->ReferenceNumber);
		$this->page->SetReservationId($this->reservationView->ReservationId);
		
		$this->page->SetIsRecurring($this->reservationView->RepeatType != RepeatType::None);
		$this->page->SetRepeatType($this->reservationView->RepeatType);
		$this->page->SetRepeatInterval($this->reservationView->RepeatInterval);
		$this->page->SetRepeatMonthlyType($this->reservationView->RepeatMonthlyType);
		if ($this->reservationView->RepeatTerminationDate != null)
		{
			$this->page->SetRepeatTerminationDate($this->reservationView->RepeatTerminationDate->ToTimezone($this->GetTimezone()));
		}
		$this->page->SetRepeatWeekdays($this->reservationView->RepeatWeekdays);
	}
	
	protected function GetOwnerId()
	{
		return $this->reservationView->OwnerId;
	}
	
	protected function GetResourceId()
	{
		return $this->reservationView->ResourceId;
	}
	
	protected function GetScheduleId()
	{
		return $this->reservationView->ScheduleId;
	}
	
	protected function GetStartDate()
	{
		return $this->reservationView->StartDate;
	}
	
	protected function GetEndDate()
	{
		return $this->reservationView->EndDate;
	}
	
	protected function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}
}
?>