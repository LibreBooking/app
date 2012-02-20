<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
	 * @param IExistingReservationPage $page
	 * @param IScheduleRepository $scheduleRepository
	 * @param IUserRepository $userRepository
	 * @param IResourceService $resourceService
	 * @param ReservationView $reservationView
	 * @param IReservationAuthorization $reservationAuthorization
	 * @param UserSession $userSession
	 */
	public function __construct(
		IExistingReservationPage $page, 
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		ReservationView $reservationView,
		IReservationAuthorization $reservationAuthorization,
		UserSession $userSession
		)
	{
		$this->page = $page;
		$this->reservationView = $reservationView;

		parent::__construct(
						$page, 
						$scheduleRepository, 
						$userRepository,
						$resourceService,
						$reservationAuthorization,
						$userSession);
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

		$this->page->SetIsEditable($this->reservationAuthorization->CanEdit($this->reservationView, $this->currentUser));
		$this->page->SetIsApprovable($this->reservationAuthorization->CanApprove($this->reservationView, $this->currentUser));

		$participants = $this->GetParticipants();
		$invitees = $this->GetInvitees();
		
		$this->page->SetParticipants($participants);
		$this->page->SetInvitees($invitees);
		$this->page->SetAccessories($this->reservationView->Accessories);

		$this->page->SetCurrentUserParticipating($this->IsCurrentUserParticipating());
		$this->page->SetCurrentUserInvited($this->IsCurrentUserInvited());
	}
	
	protected function SetSelectedDates(Date $startDate, Date $endDate, $schedulePeriods)
	{
		$timezone = $this->GetTimezone();		
		$startDate = $this->reservationView->StartDate->ToTimezone($timezone);
		$endDate = $this->reservationView->EndDate->ToTimezone($timezone);

		parent::SetSelectedDates($startDate, $endDate, $schedulePeriods);
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
?>