<?php
/**
Copyright 2012-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IReservationComponentBinder
{
	public function Bind(IReservationComponentInitializer $initializer);
}

class ReservationDateBinder implements IReservationComponentBinder
{
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IScheduleRepository $scheduleRepository)
	{
		$this->scheduleRepository = $scheduleRepository;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$timezone = $initializer->GetTimezone();
		$reservationDate = $initializer->GetReservationDate();
		$requestedEndDate = $initializer->GetEndDate();
		$requestedStartDate = $initializer->GetStartDate();
		$requestedScheduleId = $initializer->GetScheduleId();

		$requestedDate = ($reservationDate == null) ? Date::Now()->ToTimezone($timezone) : $reservationDate->ToTimezone($timezone);

		$startDate = ($requestedStartDate == null) ? $requestedDate : $requestedStartDate->ToTimezone($timezone);
		$endDate = ($requestedEndDate == null) ? $requestedDate : $requestedEndDate->ToTimezone($timezone);

		if ($initializer->IsNew())
		{
			$resource = $initializer->PrimaryResource();

			if ($resource->GetMinLength() != null && !$resource->GetMinLength()->Interval()->IsNull())
			{
				$endDate = $startDate->ApplyDifference($resource->GetMinLength()->Interval());
			}
		}

		$layout = $this->scheduleRepository->GetLayout($requestedScheduleId, new ReservationLayoutFactory($timezone));
		$startPeriods = $layout->GetLayout($startDate);
		if (count($startPeriods) > 1 && $startPeriods[0]->Begin()->Compare($startPeriods[1]->Begin()) > 0)
		{
			$period = array_shift($startPeriods);
			$startPeriods[] = $period;
		}
		$endPeriods = $layout->GetLayout($endDate);

		if (empty($requestedStartDate))
		{
			$startDate = $startDate->SetTime($startPeriods[0]->Begin());
		}
		if (empty($requestedEndDate))
		{
			$endDate = $endDate->SetTime($startPeriods[0]->End());
		}
		$initializer->SetDates($startDate, $endDate, $startPeriods, $endPeriods);

		$hideRecurrence = !$initializer->CurrentUser()->IsAdmin && Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION,
																											ConfigKeys::RESERVATION_PREVENT_RECURRENCE,
																											new BooleanConverter());
		$initializer->HideRecurrence($hideRecurrence);
	}
}

class ReservationUserBinder implements IReservationComponentBinder
{
	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * @var IReservationAuthorization
	 */
	private $reservationAuthorization;

	/**
	 * @param IUserRepository $userRepository
	 * @param IReservationAuthorization $reservationAuthorization
	 */
	public function __construct($userRepository, $reservationAuthorization)
	{
		$this->userRepository = $userRepository;
		$this->reservationAuthorization = $reservationAuthorization;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$userId = $initializer->GetOwnerId();
		$currentUser = $initializer->CurrentUser();
		$canChangeUser = $this->reservationAuthorization->CanChangeUsers($currentUser);

		$initializer->SetCanChangeUser($canChangeUser);

		$reservationUser = $this->userRepository->GetById($userId);
		$initializer->SetReservationUser($reservationUser);

		$hideUser = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
															 ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
															 new BooleanConverter());

		$initializer->ShowUserDetails(!$hideUser || $currentUser->IsAdmin);
		$initializer->SetShowParticipation(!$hideUser || $currentUser->IsAdmin || $currentUser->IsGroupAdmin);

		$currentUser = $this->userRepository->LoadById($initializer->CurrentUser()->UserId);
		$owner = $this->userRepository->LoadById($userId);

		$initializer->SetIsAdminForUser($currentUser->IsAdminFor($owner));
	}
}

class ReservationResourceBinder implements IReservationComponentBinder
{
	/**
	 * @var IResourceService
	 */
	private $resourceService;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IResourceService $resourceService, IUserRepository $userRepository)
	{
		$this->resourceService = $resourceService;
		$this->userRepository = $userRepository;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$requestedScheduleId = $initializer->GetScheduleId();
		$requestedResourceId = $initializer->GetResourceId();
		$groups = $this->resourceService->GetResourceGroups($requestedScheduleId, $initializer->CurrentUser());

		$resources = $groups->GetAllResources();
		if (empty($requestedResourceId) && count($resources) > 0)
		{
			/** @var ResourceGroupAssignment $first */
			$first = reset($resources);
			$requestedResourceId = $first->GetId();
		}

		$bindableResourceData = $this->GetBindableResourceData($resources, $requestedResourceId);

		if ($bindableResourceData->NumberAccessible <= 0)
		{
			$initializer->RedirectToError(ErrorMessages::INSUFFICIENT_PERMISSIONS);
			return;
		}

		$user = $this->userRepository->LoadById($initializer->CurrentUser()->UserId);

		foreach ($resources as $resource)
		{
			if ($user->IsResourceAdminFor($resource))
			{
				$initializer->SetIsAdminForResource(true);
				break;
			}
		}

		$initializer->BindResourceGroups($groups);
		$initializer->BindAvailableResources($resources);
		$accessories = $this->resourceService->GetAccessories();
		$initializer->BindAvailableAccessories($accessories);
		$initializer->ShowAdditionalResources($bindableResourceData->NumberAccessible > 0);
		$initializer->SetReservationResource($bindableResourceData->ReservationResource);
	}

	/**
	 * @param $resources array|ResourceGroupAssignment[]
	 * @param $requestedResourceId int
	 * @return BindableResourceData
	 */
	private function GetBindableResourceData($resources, $requestedResourceId)
	{
		$bindableResourceData = new BindableResourceData();

		/** @var $resource ResourceGroupAssignment */
		foreach ($resources as $resource)
		{
			$bindableResourceData->AddAvailableResource($resource->GetResource());
			if ($resource->GetId() == $requestedResourceId)
			{
				$bindableResourceData->SetReservationResource($resource->GetResource());
			}
		}

		return $bindableResourceData;
	}
}
//
//class ReservationCustomAttributeBinder implements IReservationComponentBinder
//{
//	/**
//	 * @var IAttributeRepository
//	 */
//	private $repository;
//
//	public function __construct(IAttributeRepository $repository)
//	{
//		$this->repository = $repository;
//	}
//
//	public function Bind(IReservationComponentInitializer $initializer)
//	{
//		$attributes = $this->repository->GetByCategory(CustomAttributeCategory::RESERVATION);
//
//		$showAdminAttributes = $initializer->GetIsAdminForUser() || $initializer->GetIsAdminForResource();
//
//		foreach ($attributes as $attribute)
//		{
//			if (!$attribute->AdminOnly() || ($attribute->AdminOnly() && $showAdminAttributes))
//			{
//				$initializer->AddAttribute($attribute, null);
//			}
//		}
//	}
//}
//
//class ReservationCustomAttributeValueBinder implements IReservationComponentBinder
//{
//	/**
//	 * @var IAttributeRepository
//	 */
//	private $repository;
//
//	/**
//	 * @var ReservationView
//	 */
//	private $reservationView;
//
//	public function __construct(IAttributeRepository $repository, ReservationView $reservationView)
//	{
//		$this->repository = $repository;
//		$this->reservationView = $reservationView;
//	}
//
//	public function Bind(IReservationComponentInitializer $initializer)
//	{
//		$attributes = $this->repository->GetByCategory(CustomAttributeCategory::RESERVATION);
//
//		$showAdminAttributes = $initializer->GetIsAdminForUser() || $initializer->GetIsAdminForResource();
//
//		foreach ($attributes as $attribute)
//		{
//			if (!$attribute->AdminOnly() || ($attribute->AdminOnly() && $showAdminAttributes))
//			{
//				$initializer->AddAttribute($attribute, $this->reservationView->GetAttributeValue($attribute->Id()));
//			}
//		}
//	}
//}

class ReservationDetailsBinder implements IReservationComponentBinder
{
	/**
	 * @var IReservationAuthorization
	 */
	private $reservationAuthorization;

	/**
	 * @var IExistingReservationPage
	 */
	private $page;

	/**
	 * @var ReservationView
	 */
	private $reservationView;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	public function __construct(IReservationAuthorization $reservationAuthorization, IExistingReservationPage $page,
								ReservationView $reservationView, IPrivacyFilter $privacyFilter)
	{
		$this->reservationAuthorization = $reservationAuthorization;
		$this->page = $page;
		$this->reservationView = $reservationView;
		$this->privacyFilter = $privacyFilter;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$this->page->SetAdditionalResources($this->reservationView->AdditionalResourceIds);
		$this->page->SetTitle($this->reservationView->Title);
		$this->page->SetDescription($this->reservationView->Description);
		$this->page->SetReferenceNumber($this->reservationView->ReferenceNumber);
		$this->page->SetReservationId($this->reservationView->ReservationId);
		$this->page->SetSeriesId($this->reservationView->SeriesId);

		$this->page->SetIsRecurring($this->reservationView->IsRecurring());
		$this->page->SetRepeatType($this->reservationView->RepeatType);
		$this->page->SetRepeatInterval($this->reservationView->RepeatInterval);
		$this->page->SetRepeatMonthlyType($this->reservationView->RepeatMonthlyType);

		if ($this->reservationView->RepeatTerminationDate != null)
		{
			$this->page->SetRepeatTerminationDate($this->reservationView->RepeatTerminationDate->ToTimezone($initializer->GetTimezone()));
		}
		$this->page->SetRepeatWeekdays($this->reservationView->RepeatWeekdays);


		$participants = $this->reservationView->Participants;
		$invitees = $this->reservationView->Invitees;

		$this->page->SetParticipants($participants);
		$this->page->SetInvitees($invitees);
		$this->page->SetAccessories($this->reservationView->Accessories);

		$currentUser = $initializer->CurrentUser();

		$this->page->SetCurrentUserParticipating($this->IsCurrentUserParticipating($currentUser->UserId));
		$this->page->SetCurrentUserInvited($this->IsCurrentUserInvited($currentUser->UserId));

		$canBeEdited = $this->reservationAuthorization->CanEdit($this->reservationView, $currentUser);
		$this->page->SetIsEditable($canBeEdited);
		$this->page->SetIsApprovable($this->reservationAuthorization->CanApprove($this->reservationView, $currentUser));

		$this->page->SetAttachments($this->reservationView->Attachments);

		$showUser = $this->privacyFilter->CanViewUser($initializer->CurrentUser(), $this->reservationView);
		$showDetails = $this->privacyFilter->CanViewDetails($initializer->CurrentUser(), $this->reservationView);

		$initializer->ShowUserDetails($showUser);
		$initializer->ShowReservationDetails($showDetails);

		if (!empty($this->reservationView->StartReminder))
		{
			$this->page->SetStartReminder($this->reservationView->StartReminder->GetValue(),
										  $this->reservationView->StartReminder->GetInterval());
		}
		if (!empty($this->reservationView->EndReminder))
		{
			$this->page->SetEndReminder($this->reservationView->EndReminder->GetValue(),
										$this->reservationView->EndReminder->GetInterval());
		}
	}

	private function IsCurrentUserParticipating($currentUserId)
	{
		/** @var $user ReservationUserView */
		foreach ($this->reservationView->Participants as $user)
		{
			if ($user->UserId == $currentUserId)
			{
				return true;
			}
		}
		return false;
	}

	private function IsCurrentUserInvited($currentUserId)
	{
		/** @var $user ReservationUserView */
		foreach ($this->reservationView->Invitees as $user)
		{
			if ($user->UserId == $currentUserId)
			{
				return true;
			}
		}
		return false;
	}
}