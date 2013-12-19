<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

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
		$endDate   = $this->GetDate($endDateString  , $userTimezone, $filterPreferences->GetFilterEndDateDelta());

		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		$userId = $this->page->GetUserId();
		$userName = $this->page->GetUserName();
		$reservationStatusId = $this->page->GetReservationStatusId();
		$referenceNumber = $this->page->GetReferenceNumber();

		if(!$this->page->FilterButtonPressed())
		{
			// Get filter settings from db
			$referenceNumber = $filterPreferences->GetFilterReferenceNumber();
			$scheduleId = $filterPreferences->GetFilterScheduleId();
			$resourceId = $filterPreferences->GetFilterResourceId();
			$userId = $filterPreferences->GetFilterUserId();
			$userName = $filterPreferences->GetFilterUserName();
			$reservationStatusId = $filterPreferences->GetFilterReservationStatusId();
		}
		else
		{
			// Get filter settings from page and save them in db
			$startOffset = $this->GetDateOffsetFromToday($startDate, $userTimezone);
			$endOffset = $this->GetDateOffsetFromToday($endDate, $userTimezone);

			$filterPreferences->SetFilterStartDateDelta($startOffset == null ? -14 : $startOffset);
			$filterPreferences->SetFilterEndDateDelta($endOffset == null ? 14 : $endOffset);
			$filterPreferences->SetFilterReferenceNumber($referenceNumber);
			$filterPreferences->SetFilterScheduleId($scheduleId);
			$filterPreferences->SetFilterResourceId($resourceId);
			$filterPreferences->SetFilterUserId($userId);
			$filterPreferences->SetFilterUserName($userName);
			$filterPreferences->SetFilterReservationStatusId($reservationStatusId);

			$filterPreferences->Update($this->userPreferenceRepository, $session->UserId);

		}

		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetReferenceNumber($referenceNumber);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);
		$this->page->SetUserId($userId);
		$this->page->SetUserName($userName);
		$this->page->SetReservationStatusId($reservationStatusId);

		$filter = new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId, $reservationStatusId);

		$reservations = $this->manageReservationsService->LoadFiltered($this->page->GetPageNumber(),
																	   $this->page->GetPageSize(),
																	   $filter,
																	   $session);

		$reservationList = $reservations->Results();
		$this->page->BindReservations($reservationList);
		$this->page->BindPageInfo($reservations->PageInfo());

		$seriesIds = array();
		/** @var $reservationItemView ReservationItemView */
		foreach ($reservationList as $reservationItemView)
		{
			$seriesIds[] = $reservationItemView->SeriesId;
		}

		$attributeList = $this->attributeService->GetAttributes(CustomAttributeCategory::RESERVATION, $seriesIds);
		$this->page->SetAttributes($attributeList);

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

	public function GetFilterStartDateDelta()
	{
		return $this->FilterStartDateDelta;
	}

	public function GetFilterEndDateDelta()
	{
		return $this->FilterEndDateDelta;
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
		if (!$FilterScheduleId)
		{
			$FilterScheduleId = '0';
		}

		$this->FilterScheduleId = $FilterScheduleId;
	}

	public function SetFilterResourceId($FilterResourceId)
	{
		if (!$FilterResourceId)
		{
			$FilterResourceId = '0';
		}

		$this->FilterResourceId = $FilterResourceId;
	}

	public function SetFilterReservationStatusId($FilterReservationStatusId)
	{
		if (!$FilterReservationStatusId)
		{
			$FilterReservationStatusId = '0';
		}

		$this->FilterReservationStatusId = $FilterReservationStatusId;
	}

	public function SetFilterReferenceNumber($FilterReferenceNumber)
	{
		$this->FilterReferenceNumber = $FilterReferenceNumber;
	}

	static $filterKeys = array('FilterStartDateDelta' => -7,
		'FilterEndDateDelta' => +7,
		'FilterUserId' => '',
		'FilterUserName' => '',
		'FilterScheduleId' => '',
		'FilterResourceId' => '',
		'FilterReservationStatusId' => 0,
		'FilterReferenceNumber' => '',
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

?>