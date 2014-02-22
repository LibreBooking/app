<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ManageReservationsActions
{
	const UpdateAttribute = 'updateAttribute';
	const ChangeStatus = 'changeStatus';
}

class ManageReservationsPresenter extends ActionPresenter
{
	/**
	 * @var IManageReservationsPage
	 */
	private $page;

	/**
	 * @var IManageReservationsService
	 */
	private $manageReservationsService;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IUserPreferenceRepository
	 */
	private $userPreferenceRepository;

	public function __construct(
		IManageReservationsPage $page,
		IManageReservationsService $manageReservationsService,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository,
		IAttributeService $attributeService,
		IUserPreferenceRepository $userPreferenceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->manageReservationsService = $manageReservationsService;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeService;
		$this->userPreferenceRepository = $userPreferenceRepository;

		$this->AddAction(ManageReservationsActions::UpdateAttribute, 'UpdateAttribute');
		$this->AddAction(ManageReservationsActions::ChangeStatus, 'UpdateResourceStatus');
	}

	public function PageLoad($userTimezone)
	{
		$session = ServiceLocator::GetServer()->GetUserSession();

		$this->page->BindSchedules($this->scheduleRepository->GetAll());
		$this->page->BindResources($this->resourceRepository->GetResourceList());

		$statusReasonList = array();
		foreach ($this->resourceRepository->GetStatusReasons() as $reason)
		{
			$statusReasonList[$reason->Id()] = $reason;
		}
		$this->page->BindResourceStatuses($statusReasonList);

		$startDateString = $this->page->GetStartDate();
		$endDateString = $this->page->GetEndDate();

		$filterPreferences = new ReservationFilterPreferences();
		$filterPreferences->Load($this->userPreferenceRepository, $session->UserId);

		$startDate = $this->GetDate($startDateString, $userTimezone, $filterPreferences->GetFilterStartDateDelta());
		$endDate = $this->GetDate($endDateString, $userTimezone, $filterPreferences->GetFilterEndDateDelta());

		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		$userId = $this->page->GetUserId();
		$userName = $this->page->GetUserName();
		$reservationStatusId = $this->page->GetReservationStatusId();
		$referenceNumber = $this->page->GetReferenceNumber();
		$resourceStatusId = $this->page->GetResourceStatusFilterId();
		$resourceReasonId = $this->page->GetResourceStatusReasonFilterId();

		if(!$this->page->FilterButtonPressed())
		{
			// Get filter settings from db
			$referenceNumber = $filterPreferences->GetFilterReferenceNumber();
			$scheduleId = $filterPreferences->GetFilterScheduleId();
			$resourceId = $filterPreferences->GetFilterResourceId();
			$userId = $filterPreferences->GetFilterUserId();
			$userName = $filterPreferences->GetFilterUserName();
			$reservationStatusId = $filterPreferences->GetFilterReservationStatusId();
			$resourceStatusId = $filterPreferences->GetFilterResourceStatusId();
			$resourceReasonId = $filterPreferences->GetFilterResourceReasonId();
			$filters = $filterPreferences->GetFilterCustomAttributes();
		}
		else
		{
			$startOffset = $this->GetDateOffsetFromToday($startDate, $userTimezone);
			$endOffset = $this->GetDateOffsetFromToday($endDate, $userTimezone);

			$formFilters = $this->page->GetAttributeFilters();
			$filters = array();
			foreach ($formFilters as $filter)
			{
				$filters[$filter->Id] = $filter->Value;
			}

			$filterPreferences->SetFilterStartDateDelta($startOffset == null ? -14 : $startOffset);
			$filterPreferences->SetFilterEndDateDelta($endOffset == null ? 14 : $endOffset);
			$filterPreferences->SetFilterReferenceNumber($referenceNumber);
			$filterPreferences->SetFilterScheduleId($scheduleId);
			$filterPreferences->SetFilterResourceId($resourceId);
			$filterPreferences->SetFilterUserId($userId);
			$filterPreferences->SetFilterUserName($userName);
			$filterPreferences->SetFilterReservationStatusId($reservationStatusId);
			$filterPreferences->SetFilterResourceStatusId($resourceStatusId);
			$filterPreferences->SetFilterResourceReasonId($resourceReasonId);
			$filterPreferences->SetFilterCustomAttributes($filters);

			$filterPreferences->Update($this->userPreferenceRepository, $session->UserId);
		}

		$reservationAttributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESERVATION);

		$attributeFilters = array();
		foreach ($reservationAttributes as $attribute)
		{
			$attributeValue = null;
			if (array_key_exists($attribute->Id(), $filters))
			{
				$attributeValue = $filters[$attribute->Id()];
			}
			$attributeFilters[] = new Attribute($attribute, $attributeValue);
		}

		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetReferenceNumber($referenceNumber);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);
		$this->page->SetUserId($userId);
		$this->page->SetUserName($userName);
		$this->page->SetReservationStatusId($reservationStatusId);
		$this->page->SetResourceStatusFilterId($resourceStatusId);
		$this->page->SetResourceStatusReasonFilterId($resourceReasonId);
		$this->page->SetAttributeFilters($attributeFilters);
		$this->page->SetReservationAttributes($reservationAttributes);

		$filter = new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId,
										$reservationStatusId, $resourceStatusId, $resourceReasonId, $attributeFilters);

		$reservations = $this->manageReservationsService->LoadFiltered($this->page->GetPageNumber(),
																	   $this->page->GetPageSize(),
																	   $filter,
																	   $session);

		/** @var ReservationItemView[] $reservationList */
		$reservationList = $reservations->Results();
		$this->page->BindReservations($reservationList);
		$this->page->BindPageInfo($reservations->PageInfo());

		$seriesIds = array();
		/** @var $reservationItemView ReservationItemView */
		foreach ($reservationList as $reservationItemView)
		{
			$seriesIds[] = $reservationItemView->SeriesId;
		}

		if ($this->page->GetFormat() == 'csv')
		{
			$this->page->ShowCsv();
		}
		else
		{
			$this->page->ShowPage();
		}
	}

	private function GetDate($dateString, $timezone, $defaultDays)
	{
		$date = null;

		if (empty($defaultDays))
		{
			return null;
		}

		if (is_null($dateString))
		{
			$date = Date::Now()->AddDays($defaultDays)->ToTimezone($timezone)->GetDate();
		}
		elseif (!empty($dateString))
		{
			$date = Date::Parse($dateString, $timezone);
		}

		return $date;
	}

	private function GetDateOffsetFromToday($date, $timezone)
	{
		if (empty($date))
		{
			return null;
		}

		$today = Date::Create(Date('Y'), Date('m'), Date('d'), 0, 0, 0, $timezone);
		$diff = DateDiff::BetweenDates($today, $date);
		return $diff->Days();
	}

	public function UpdateResourceStatus()
	{
		if (!$this->page->CanUpdateResourceStatuses())
		{
			Log::Debug('User does not have rights to update resource statuses');

			return;
		}

		$session = ServiceLocator::GetServer()->GetUserSession();
		$statusId = $this->page->GetResourceStatus();
		$reasonId = $this->page->GetResourceStatusReason();
		$referenceNumber = $this->page->GetResourceStatusReferenceNumber();
		$resourceId = $this->page->GetUpdateResourceId();
		$updateScope = $this->page->GetUpdateScope();

		Log::Debug('Updating resource status. ResourceId=%s, ReferenceNumber=%s, StatusId=%s, ReasonId=%s, UserId=%s',
				   $resourceId,
					$referenceNumber,
					$statusId,
					$reasonId,
					$session->UserId);

		$resourceIds = array();

		if (empty($updateScope))
		{
			$resourceIds[] = $resourceId;
		}
		else
		{
			$reservations = $this->manageReservationsService->LoadFiltered(null, null, new ReservationFilter(null, null, $referenceNumber, null, null, null, null), $session);
			/** @var $reservation ReservationItemView */
			foreach ($reservations->Results() as $reservation)
			{
				$resourceIds[] = $reservation->ResourceId;
			}
		}

		foreach ($resourceIds as $id)
		{
			$resource = $this->resourceRepository->LoadById($id);
			$resource->ChangeStatus($statusId, $reasonId);
			$this->resourceRepository->Update($resource);
		}
	}

	public function ProcessDataRequest($dataRequest)
	{
		if ($dataRequest == 'load')
		{
			$referenceNumber = $this->page->GetReferenceNumber();

			$rv = $this->manageReservationsService->LoadByReferenceNumber($referenceNumber, ServiceLocator::GetServer()->GetUserSession());
			$this->page->SetReservationJson($rv);
		}
	}

	public function UpdateAttribute()
	{
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		$referenceNumber = $this->page->GetReferenceNumber();
		$attributeId = $this->page->GetAttributeId();
		$attributeValue = $this->page->GetAttributeValue();

		Log::Debug('Updating reservation attribute. UserId=%s, AttributeId=%s, AttributeValue=%s, ReferenceNumber=%s', $userSession->UserId, $attributeId, $attributeValue, $referenceNumber);

		$errors = $this->manageReservationsService->UpdateAttribute($referenceNumber, $attributeId, $attributeValue, $userSession);
		if (!empty($errors))
		{
			$this->page->BindAttributeUpdateErrors($errors);
		}
	}
}

class ReservationFilterPreferences
{
	private $FilterStartDateDelta = 0;
	private $FilterEndDateDelta = 0;
	private $FilterUserId = 0;
	private $FilterUserName = '';
	private $FilterScheduleId = 0;
	private $FilterResourceId = 0;
	private $FilterReservationStatusId = 0;
	private $FilterReferenceNumber = '';
	private $FilterResourceStatusId = '';
	private $FilterResourceReasonId = '';
	private $FilterCustomAttributes = '';

	public function GetFilterStartDateDelta()
	{
		return empty($this->FilterStartDateDelta) ? -14 : $this->FilterStartDateDelta;
	}

	public function GetFilterEndDateDelta()
	{
		return empty($this->FilterEndDateDelta) ? 14 : $this->FilterEndDateDelta;
	}

	public function GetFilterUserId()
	{
		return $this->FilterUserId;
	}

	public function GetFilterUserName()
	{
		return $this->FilterUserName;
	}

	public function GetFilterScheduleId()
	{
		return $this->FilterScheduleId;
	}

	public function GetFilterResourceId()
	{
		return $this->FilterResourceId;
	}

	public function GetFilterReservationStatusId()
	{
		return $this->FilterReservationStatusId;
	}

	public function GetFilterReferenceNumber()
	{
		return $this->FilterReferenceNumber;
	}

	public function GetFilterResourceStatusId()
	{
		return $this->FilterResourceStatusId;
	}

	public function GetFilterResourceReasonId()
	{
		return $this->FilterResourceReasonId;
	}

	public function SetFilterStartDateDelta($FilterStartDateDelta)
	{
		$this->FilterStartDateDelta = $FilterStartDateDelta;
	}

	public function SetFilterEndDateDelta($FilterEndDateDelta)
	{
		$this->FilterEndDateDelta = $FilterEndDateDelta;
	}

	public function SetFilterUserId($FilterUserId)
	{
		$this->FilterUserId = $FilterUserId;
	}

	public function SetFilterUserName($FilterUserName)
	{
		$this->FilterUserName = $FilterUserName;
	}

	public function SetFilterScheduleId($FilterScheduleId)
	{
		if (empty($FilterScheduleId))
		{
			$FilterScheduleId = '0';
		}

		$this->FilterScheduleId = $FilterScheduleId;
	}

	public function SetFilterResourceId($FilterResourceId)
	{
		if (empty($FilterResourceId))
		{
			$FilterResourceId = '0';
		}

		$this->FilterResourceId = $FilterResourceId;
	}

	public function SetFilterReservationStatusId($FilterReservationStatusId)
	{
		if (empty($FilterReservationStatusId))
		{
			$FilterReservationStatusId = '0';
		}

		$this->FilterReservationStatusId = $FilterReservationStatusId;
	}

	public function SetFilterReferenceNumber($FilterReferenceNumber)
	{
		$this->FilterReferenceNumber = $FilterReferenceNumber;
	}

	public function SetFilterResourceStatusId($statusId)
	{
		$this->FilterResourceStatusId = $statusId;
	}

	public function SetFilterResourceReasonId($reasonId)
	{
		$this->FilterResourceReasonId = $reasonId;
	}

	/**
	 * @return array
	 */
	public function GetFilterCustomAttributes()
	{
		if (isset($this->FilterCustomAttributes) && !empty($this->FilterCustomAttributes))
		{
			return unserialize($this->FilterCustomAttributes);
		}

		return array();
	}

	/**
	 * @param array $filters
	 */
	public function SetFilterCustomAttributes($filters)
	{
		$this->FilterCustomAttributes = serialize($filters);
	}

	static $filterKeys = array('FilterStartDateDelta' => -7,
		'FilterEndDateDelta' => +7,
		'FilterUserId' => '',
		'FilterUserName' => '',
		'FilterScheduleId' => '',
		'FilterResourceId' => '',
		'FilterReservationStatusId' => 0,
		'FilterReferenceNumber' => '',
		'FilterResourceStatusId' => '',
		'FilterResourceReasonId' => '',
		'FilterCustomAttributes' => '',
	);

	/**
	 * @param IUserPreferenceRepository $userPreferenceRepository
	 * @param int $userId
	 */
	public function Load(IUserPreferenceRepository $userPreferenceRepository, $userId)
	{
		foreach (self::$filterKeys as $filterName => $defaultValue)
		{
			$this->$filterName = $defaultValue;
		}

		$prefs = $userPreferenceRepository->GetAllUserPreferences($userId);
		foreach ($prefs as $key => $val)
		{
			if (array_key_exists($key, self::$filterKeys))
			{
				$this->$key = $val;
			}
		}
	}

	/**
	 * @param IUserPreferenceRepository $userPreferenceRepository
	 * @param int $userId
	 */
	public function Update(IUserPreferenceRepository $userPreferenceRepository, $userId)
	{
		foreach (self::$filterKeys as $filterName => $defaultValue)
		{
			$userPreferenceRepository->SetUserPreference($userId, $filterName, $this->$filterName);
		}
	}


}