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
	
	/**
	 * @var IEditableCriteria
	 */
	private $editableCriteria;
	
	/**
	 * @param IExistingReservationPage $page
	 * @param IScheduleUserRepository $scheduleUserRepository
	 * @param IScheduleRepository $scheduleRepository
	 * @param IUserRepository $userRepository
	 * @param ReservationView $reservationView
	 * @param IEditableCriteria $editableCriteria defaults to new EditableViewCriteria
	 */
	public function __construct(
		IExistingReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		ReservationView $reservationView,
		$editableCriteria = null
		)
	{
		$this->page = $page;
		$this->reservationView = $reservationView;
		$this->editableCriteria = ($editableCriteria == null) ? new EditableViewCriteria() : $editableCriteria;

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
		$this->page->SetTitle($this->reservationView->Title);
		$this->page->SetDescription($this->reservationView->Description);
		$this->page->SetReferenceNumber($this->reservationView->ReferenceNumber);
		$this->page->SetReservationId($this->reservationView->ReservationId);
		
		$this->page->SetIsRecurring($this->reservationView->IsRecurring());
		$this->page->SetRepeatType($this->reservationView->RepeatType);
		$this->page->SetRepeatInterval($this->reservationView->RepeatInterval);
		$this->page->SetRepeatMonthlyType($this->reservationView->RepeatMonthlyType);
		if ($this->reservationView->RepeatTerminationDate != null)
		{
			$this->page->SetRepeatTerminationDate($this->reservationView->RepeatTerminationDate->ToTimezone($this->GetTimezone()));
		}
		$this->page->SetRepeatWeekdays($this->reservationView->RepeatWeekdays);
		
		$this->page->SetIsEditable($this->editableCriteria->IsEditable($this->reservationView));

		$participants = $this->GetParticipants();
		$invitees = $this->GetInvitees();
		
		$this->page->SetParticipants($participants);
		$this->page->SetInvitees($invitees);

		$this->page->SetCurrentUserParticipating($this->IsCurrentUserParticipating());
		$this->page->SetCurrentUserInvited($this->IsCurrentUserInvited());
	}
	
	protected function SetSelectedDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		$timezone = $this->GetTimezone();		
		$this->page->SetSelectedStart($this->reservationView->StartDate->ToTimezone($timezone));
		$this->page->SetSelectedEnd($this->reservationView->EndDate->ToTimezone($timezone));		
		$this->page->SetRepeatTerminationDate($this->reservationView->StartDate->ToTimezone($timezone));		
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
	
	protected function GetReservationDate()
	{
		return $this->reservationView->StartDate;
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

	protected function GetParticipants()
	{
		return $this->reservationView->Participants;
	}

	protected function GetInvitees()
	{
		return $this->reservationView->Invitees;
	}

	private function IsCurrentUserParticipating()
	{
		/** @var $user ReservationUserView */
		foreach ($this->reservationView->Participants as $user)
		{
			if ($user->UserId == $this->currentUserId)
			{
				return true;
			}
		}
		return false;
	}

	private function IsCurrentUserInvited()
	{
		/** @var $user ReservationUserView */
		foreach ($this->reservationView->Invitees as $user)
		{
			if ($user->UserId == $this->currentUserId)
			{
				return true;
			}
		}
		return false;
	}
}

interface IEditableCriteria
{
	function IsEditable(ReservationView $reservationView);
}

class EditableViewCriteria implements IEditableCriteria
{
	public function IsEditable(ReservationView $reservationView)
	{
		$currentUser = ServiceLocator::GetServer()->GetUserSession();
		
		if ($currentUser->IsAdmin)
		{
			return true;
		}
		
		if ($reservationView->OwnerId != $currentUser->UserId)
		{
			return false;
		}
		
		return Date::Now()->LessThan($reservationView->EndDate);
		
	}
}
?>