<?php
/**
Copyright 2012 Nick Korbel

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

		$layout = $this->scheduleRepository->GetLayout($requestedScheduleId, new ReservationLayoutFactory($timezone));
		$schedulePeriods = $layout->GetLayout($requestedDate);
		$initializer->SetDates($startDate, $endDate, $schedulePeriods);
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
		$canChangeUser = $this->reservationAuthorization->CanChangeUsers($initializer->CurrentUser());

		$initializer->SetCanChangeUser($canChangeUser);

		$reservationUser = $this->userRepository->GetById($userId);
		$initializer->SetReservationUser($reservationUser);

		$shouldHideDetails = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, new BooleanConverter());
		$initializer->ShowUserDetails(!$shouldHideDetails || $canChangeUser);
	}
}

class ReservationResourceBinder implements IReservationComponentBinder
{
	/**
	 * @var IResourceService
	 */
	private $resourceService;

	public function __construct(IResourceService $resourceService)
	{
		$this->resourceService = $resourceService;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$requestedScheduleId = $initializer->GetScheduleId();
		$requestedResourceId = $initializer->GetResourceId();
		$resources = $this->resourceService->GetScheduleResources($requestedScheduleId, true, $initializer->CurrentUser());

		$bindableResourceData = $this->GetBindableResourceData($resources, $requestedResourceId);

		$initializer->BindAvailableResources($bindableResourceData->AvailableResources);
		$accessories = $this->resourceService->GetAccessories();
		$initializer->BindAvailableAccessories($accessories);
		$initializer->ShowAdditionalResources($bindableResourceData->NumberAccessible > 0);
		$initializer->SetReservationResource($bindableResourceData->ReservationResource);
	}

	/**
	 * @param $resources array|ResourceDto[]
	 * @param $requestedResourceId int
	 * @return BindableResourceData
	 */
	private function GetBindableResourceData($resources, $requestedResourceId)
	{
		$bindableResourceData = new BindableResourceData();

		/** @var $resource ResourceDto */
		foreach ($resources as $resource)
		{
			if ($resource->Id != $requestedResourceId)
			{
				$bindableResourceData->AddAvailableResource($resource);
			}
			else
			{
				$bindableResourceData->SetReservationResource($resource);
			}
		}

		return $bindableResourceData;
	}
}

class ReservationCustomAttributeBinder implements IReservationComponentBinder
{
	/**
	 * @var IAttributeRepository
	 */
	private $repository;

	public function __construct(IAttributeRepository $repository)
	{
		$this->repository = $repository;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$attributes = $this->repository->GetByCategory(CustomAttributeCategory::RESERVATION);

		foreach ($attributes as $attribute)
		{
			$initializer->AddAttribute($attribute, null);
		}
	}
}

class ReservationCustomAttributeValueBinder implements IReservationComponentBinder
{
	/**
	 * @var IAttributeRepository
	 */
	private $repository;

	/**
	 * @var ReservationView
	 */
	private $reservationView;

	public function __construct(IAttributeRepository $repository, ReservationView $reservationView)
	{
		$this->repository = $repository;
		$this->reservationView = $reservationView;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
		$attributes = $this->repository->GetByCategory(CustomAttributeCategory::RESERVATION);

		foreach ($attributes as $attribute)
		{
			$initializer->AddAttribute($attribute, $this->reservationView->GetAttributeValue($attribute->Id()));
		}
	}
}

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

	public function __construct(IReservationAuthorization $reservationAuthorization, IExistingReservationPage $page, ReservationView $reservationView)
	{
		$this->reservationAuthorization = $reservationAuthorization;
		$this->page = $page;
		$this->reservationView = $reservationView;
	}

	public function Bind(IReservationComponentInitializer $initializer)
	{
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

		$this->page->SetIsEditable($this->reservationAuthorization->CanEdit($this->reservationView, $currentUser));
		$this->page->SetIsApprovable($this->reservationAuthorization->CanApprove($this->reservationView, $currentUser));

		$this->page->SetAttachments($this->reservationView->Attachments);
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
?>