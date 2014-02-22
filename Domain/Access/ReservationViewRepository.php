<?php
/**
Copyright 2011-2014 Nick Korbel
Copyright 2012-2014 Alois Schloegl

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

require_once(ROOT_DIR . 'Domain/Values/ReservationUserLevel.php');
require_once(ROOT_DIR . 'Domain/Values/ReservationStatus.php');
require_once(ROOT_DIR . 'Domain/Values/CustomAttributes.php');
require_once(ROOT_DIR . 'Domain/Values/UserPreferences.php');
require_once(ROOT_DIR . 'Domain/RepeatOptions.php');

interface IReservationViewRepository
{
	/**
	 * @abstract
	 * @var $referenceNumber string
	 * @return ReservationView
	 */
	public function GetReservationForEditing($referenceNumber);

	/**
	 * @abstract
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int|null $userId
	 * @param int|ReservationUserLevel|null $userLevel
	 * @param int|null $scheduleId
	 * @param int|null $resourceId
	 * @return ReservationItemView[]
	 */
	public function GetReservationList(
		Date $startDate,
		Date $endDate,
		$userId = ReservationViewRepository::ALL_USERS,
		$userLevel = ReservationUserLevel::OWNER,
		$scheduleId = ReservationViewRepository::ALL_SCHEDULES,
		$resourceId = ReservationViewRepository::ALL_RESOURCES);

	/**
	 * @abstract
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $accessoryName
	 * @return mixed
	 */
	public function GetAccessoryReservationList(Date $startDate, Date $endDate, $accessoryName);

	/**
	 * @abstract
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData|ReservationItemView[]
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null);

	/**
	 * @abstract
	 * @param DateRange $dateRange
	 * @param int|null $scheduleId
	 * @return BlackoutItemView[]
	 */
	public function GetBlackoutsWithin(DateRange $dateRange, $scheduleId = ReservationViewRepository::ALL_SCHEDULES);

	/**
	 * @abstract
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param null|string $sortField
	 * @param null|string $sortDirection
	 * @param null|ISqlFilter $filter
	 * @return PageableData|BlackoutItemView[]
	 */
	public function GetBlackoutList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null);

	/**
	 * @abstract
	 * @param DateRange $dateRange
	 * @return array|AccessoryReservation[]
	 */
	public function GetAccessoriesWithin(DateRange $dateRange);
}

class ReservationViewRepository implements IReservationViewRepository
{
	const ALL_SCHEDULES = -1;
	const ALL_RESOURCES = -1;
	const ALL_USERS = -1;
	const ALL_ACCESSORIES = -1;

	public function GetReservationForEditing($referenceNumber)
	{
		$reservationView = NullReservationView::Instance();

		$getReservation = new GetReservationForEditingCommand($referenceNumber);

		$result = ServiceLocator::GetDatabase()->Query($getReservation);

		while ($row = $result->GetRow())
		{
			$reservationView = new ReservationView();

			$reservationView->Description = $row[ColumnNames::RESERVATION_DESCRIPTION];
			$reservationView->EndDate = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
			$reservationView->OwnerId = $row[ColumnNames::USER_ID];
			$reservationView->ResourceId = $row[ColumnNames::RESOURCE_ID];
			$reservationView->ResourceName = $row[ColumnNames::RESOURCE_NAME];
			$reservationView->ReferenceNumber = $row[ColumnNames::REFERENCE_NUMBER];
			$reservationView->ReservationId = $row[ColumnNames::RESERVATION_INSTANCE_ID];
			$reservationView->ScheduleId = $row[ColumnNames::SCHEDULE_ID];
			$reservationView->StartDate = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$reservationView->Title = $row[ColumnNames::RESERVATION_TITLE];
			$reservationView->SeriesId = $row[ColumnNames::SERIES_ID];
			$reservationView->OwnerFirstName = $row[ColumnNames::FIRST_NAME];
			$reservationView->OwnerLastName = $row[ColumnNames::LAST_NAME];
			$reservationView->OwnerEmailAddress = $row[ColumnNames::EMAIL];
			$reservationView->StatusId = $row[ColumnNames::RESERVATION_STATUS];
			$reservationView->DateCreated = Date::FromDatabase($row[ColumnNames::RESERVATION_CREATED]);

			$repeatConfig = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE],
														$row[ColumnNames::REPEAT_OPTIONS]);

			$reservationView->RepeatType = $repeatConfig->Type;
			$reservationView->RepeatInterval = $repeatConfig->Interval;
			$reservationView->RepeatWeekdays = $repeatConfig->Weekdays;
			$reservationView->RepeatMonthlyType = $repeatConfig->MonthlyType;
			$reservationView->RepeatTerminationDate = $repeatConfig->TerminationDate;

			$this->SetResources($reservationView);
			$this->SetParticipants($reservationView);
			$this->SetAccessories($reservationView);
			$this->SetAttributes($reservationView);
			$this->SetAttachments($reservationView);
			$this->SetReminders($reservationView);
		}

		return $reservationView;
	}

	public function GetReservationList(
		Date $startDate,
		Date $endDate,
		$userId = self::ALL_USERS,
		$userLevel = ReservationUserLevel::OWNER,
		$scheduleId = self::ALL_SCHEDULES,
		$resourceId = self::ALL_RESOURCES)
	{
		if (empty($userId))
		{
			$userId = self::ALL_USERS;
		}
		if (is_null($userLevel))
		{
			$userLevel = ReservationUserLevel::OWNER;
		}
		if (empty($scheduleId))
		{
			$scheduleId = self::ALL_SCHEDULES;
		}
		if (empty($resourceId))
		{
			$resourceId = self::ALL_RESOURCES;
		}

		$getReservations = new GetReservationListCommand($startDate, $endDate, $userId, $userLevel, $scheduleId, $resourceId);

		$result = ServiceLocator::GetDatabase()->Query($getReservations);

		$reservations = array();

		while ($row = $result->GetRow())
		{
			$reservations[] = ReservationItemView::Populate($row);
		}

		$result->Free();

		return $reservations;
	}

	public function GetAccessoryReservationList(Date $startDate, Date $endDate, $accessoryName)
	{
		$getReservations = new GetReservationsByAccessoryNameCommand($startDate, $endDate, $accessoryName);

		$result = ServiceLocator::GetDatabase()->Query($getReservations);

		$reservations = array();

		while ($row = $result->GetRow())
		{
			$reservations[] = ReservationItemView::Populate($row);
		}

		$result->Free();

		return $reservations;
	}

	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		$command = new GetFullReservationListCommand();

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('ReservationItemView', 'Populate');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}

	private function SetResources(ReservationView $reservationView)
	{
		$getResources = new GetReservationResourcesCommand($reservationView->SeriesId);

		$result = ServiceLocator::GetDatabase()->Query($getResources);

		while ($row = $result->GetRow())
		{
			if ($row[ColumnNames::RESOURCE_LEVEL_ID] == ResourceLevel::Additional)
			{
				$reservationView->AdditionalResourceIds[] = $row[ColumnNames::RESOURCE_ID];
			}
			$reservationView->Resources[] = new ReservationResourceView(
				$row[ColumnNames::RESOURCE_ID],
				$row[ColumnNames::RESOURCE_NAME],
				$row[ColumnNames::RESOURCE_ADMIN_GROUP_ID],
				$row[ColumnNames::SCHEDULE_ID],
				$row[ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS],
				$row[ColumnNames::RESOURCE_STATUS_ID]
			);
		}
	}

	private function SetParticipants(ReservationView $reservationView)
	{
		$getParticipants = new GetReservationParticipantsCommand($reservationView->ReservationId);

		$result = ServiceLocator::GetDatabase()->Query($getParticipants);

		while ($row = $result->GetRow())
		{
			$levelId = $row[ColumnNames::RESERVATION_USER_LEVEL];
			$reservationUserView = new ReservationUserView(
				$row[ColumnNames::USER_ID],
				$row[ColumnNames::FIRST_NAME],
				$row[ColumnNames::LAST_NAME],
				$row[ColumnNames::EMAIL],
				$levelId);

			if ($levelId == ReservationUserLevel::PARTICIPANT)
			{
				$reservationView->Participants[] = $reservationUserView;
			}

			if ($levelId == ReservationUserLevel::INVITEE)
			{
				$reservationView->Invitees[] = $reservationUserView;
			}
		}
	}

	private function SetAccessories(ReservationView $reservationView)
	{
		$getAccessories = new GetReservationAccessoriesCommand($reservationView->SeriesId);

		$result = ServiceLocator::GetDatabase()->Query($getAccessories);

		while ($row = $result->GetRow())
		{
			$reservationView->Accessories[] = new ReservationAccessoryView($row[ColumnNames::ACCESSORY_ID], $row[ColumnNames::QUANTITY], $row[ColumnNames::ACCESSORY_NAME], $row[ColumnNames::ACCESSORY_QUANTITY]);
		}
	}

	private function SetAttributes(ReservationView $reservationView)
	{
		$getAttributes = new GetAttributeValuesCommand($reservationView->SeriesId, CustomAttributeCategory::RESERVATION);

		$result = ServiceLocator::GetDatabase()->Query($getAttributes);

		while ($row = $result->GetRow())
		{
			$reservationView->AddAttribute(new AttributeValue($row[ColumnNames::ATTRIBUTE_ID], $row[ColumnNames::ATTRIBUTE_VALUE], $row[ColumnNames::ATTRIBUTE_LABEL]));
		}
	}

	private function SetAttachments(ReservationView $reservationView)
	{
		$getAttachments = new GetReservationAttachmentsCommand($reservationView->SeriesId);

		$result = ServiceLocator::GetDatabase()->Query($getAttachments);

		while ($row = $result->GetRow())
		{
			$reservationView->AddAttachment(new ReservationAttachmentView($row[ColumnNames::FILE_ID], $row[ColumnNames::SERIES_ID], $row[ColumnNames::FILE_NAME]));
		}
	}

	private function SetReminders(ReservationView $reservationView)
	{
		$getReminders = new GetReservationReminders($reservationView->SeriesId);
		$result = ServiceLocator::GetDatabase()->Query($getReminders);
		while ($row = $result->GetRow())
		{
			if ($row[ColumnNames::REMINDER_TYPE] == ReservationReminderType::Start)
			{
				$reservationView->StartReminder = new ReservationReminderView($row[ColumnNames::REMINDER_MINUTES_PRIOR]);
			}
			else
			{
				$reservationView->EndReminder = new ReservationReminderView($row[ColumnNames::REMINDER_MINUTES_PRIOR]);
			}
		}
	}

	public function GetAccessoriesWithin(DateRange $dateRange)
	{
		$getAccessoriesCommand = new GetAccessoryListCommand($dateRange->GetBegin(), $dateRange->GetEnd());

		$result = ServiceLocator::GetDatabase()->Query($getAccessoriesCommand);

		$accessories = array();
		while ($row = $result->GetRow())
		{
			$accessories[] = new AccessoryReservation(
				$row[ColumnNames::REFERENCE_NUMBER],
				Date::FromDatabase($row[ColumnNames::RESERVATION_START]),
				Date::FromDatabase($row[ColumnNames::RESERVATION_END]),
				$row[ColumnNames::ACCESSORY_ID],
				$row[ColumnNames::QUANTITY]);
		}

		$result->Free();

		return $accessories;
	}

	public function GetBlackoutsWithin(DateRange $dateRange, $scheduleId = ReservationViewRepository::ALL_SCHEDULES)
	{
		$getBlackoutsCommand = new GetBlackoutListCommand($dateRange->GetBegin(), $dateRange->GetEnd(), $scheduleId);

		$result = ServiceLocator::GetDatabase()->Query($getBlackoutsCommand);

		$blackouts = array();
		while ($row = $result->GetRow())
		{
			$blackouts[] = BlackoutItemView::Populate($row);
		}

		$result->Free();

		return $blackouts;
	}

	public function GetBlackoutList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null)
	{
		$command = new GetBlackoutListFullCommand();

		if ($filter != null)
		{
			$command = new FilterCommand($command, $filter);
		}

		$builder = array('BlackoutItemView', 'Populate');
		return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
	}
}

class ReservationResourceView implements IResource
{
	private $_id;
	private $_resourceName;
	private $_adminGroupId;
	private $_scheduleId;
	private $_scheduleAdminGroupId;
	private $_statusId;

	public function __construct($resourceId, $resourceName, $adminGroupId, $scheduleId, $scheduleAdminGroupId, $statusId = ResourceStatus::AVAILABLE)
	{
		$this->_id = $resourceId;
		$this->_resourceName = $resourceName;
		$this->_adminGroupId = $adminGroupId;
		$this->_scheduleId = $scheduleId;
		$this->_scheduleAdminGroupId = $scheduleAdminGroupId;
		$this->_statusId = $statusId;
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->_id;
	}

	/**
	 * @return string
	 */
	public function Name()
	{
		return $this->_resourceName;
	}

	/**
	 * @return int|null
	 */
	public function GetAdminGroupId()
	{
		return $this->_adminGroupId;
	}

	/**
	 * alias of GetId()
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->Id();
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->Id();
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->Name();
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->_scheduleId;
	}

	/**
	 * @return int
	 */
	public function GetScheduleAdminGroupId()
	{
		return $this->_scheduleAdminGroupId;
	}

	/**
	 * @return int
	 */
	public function GetStatusId()
	{
		return $this->_statusId;
	}
}

class ReservationUserView
{
	public $UserId;
	public $FirstName;
	public $LastName;
	public $Email;
	public $LevelId;
	public $FullName;

	public function __construct($userId, $firstName, $lastName, $email, $levelId)
	{
		$this->UserId = $userId;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
		$this->FullName = $firstName . ' ' . $lastName;
		$this->Email = $email;
		$this->LevelId = $levelId;
	}

	public function IsOwner()
	{
		return $this->LevelId == ReservationUserLevel::OWNER;
	}

	public function __toString()
	{
		return $this->UserId;
	}
}

class NullReservationView extends ReservationView
{
	/**
	 * @var NullReservationView
	 */
	private static $instance;

	private function __construct()
	{
	}

	public static function Instance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new NullReservationView();
		}

		return self::$instance;
	}

	public function IsDisplayable()
	{
		return false;
	}
}

class ReservationAccessoryView
{
	/**
	 * @var int
	 */
	public $AccessoryId;

	/**
	 * @var int
	 */
	public $QuantityReserved;

	/**
	 * @var int
	 */
	public $QuantityAvailable;

	/**
	 * @var null|string
	 */
	public $Name;

	/**
	 * @param int $accessoryId
	 * @param int $quantityReserved
	 * @param string $accessoryName
	 * @param int $quantityAvailable
	 */
	public function __construct($accessoryId, $quantityReserved, $accessoryName, $quantityAvailable)
	{
		$this->AccessoryId = $accessoryId;
		$this->QuantityReserved = $quantityReserved;
		$this->Name = $accessoryName;
		$this->QuantityAvailable = $quantityAvailable;
	}
}

class ReservationView
{
	public $ReservationId;
	public $SeriesId;
	public $ReferenceNumber;
	public $ResourceId;
	public $ResourceName;
	public $ScheduleId;
	public $StatusId;
	/**
	 * @var Date
	 */
	public $StartDate;
	/**
	 * @var Date
	 */
	public $EndDate;
	/**
	 * @var Date
	 */
	public $DateCreated;
	public $OwnerId;
	public $OwnerEmailAddress;
	public $OwnerFirstName;
	public $OwnerLastName;
	public $Title;
	public $Description;
	/**
	 * @var string|RepeatType
	 */
	public $RepeatType;
	/**
	 * @var int
	 */
	public $RepeatInterval;
	/**
	 * @var array
	 */
	public $RepeatWeekdays;
	/**
	 * @var string|RepeatMonthlyType
	 */
	public $RepeatMonthlyType;
	/**
	 * @var Date
	 */
	public $RepeatTerminationDate;
	/**
	 * @var int[]
	 */
	public $AdditionalResourceIds = array();

	/**
	 * @var ReservationResourceView[]
	 */
	public $Resources = array();

	/**
	 * @var ReservationUserView[]
	 */
	public $Participants = array();

	/**
	 * @var ReservationUserView[]
	 */
	public $Invitees = array();

	/**
	 * @var array|ReservationAccessoryView[]
	 */
	public $Accessories = array();

	/**
	 * @var array|AttributeValue[]
	 */
	public $Attributes = array();

	/**
	 * @var array|ReservationAttachmentView[]
	 */
	public $Attachments = array();

	/**
	 * @var ReservationReminderView|null
	 */
	public $StartReminder;

	/**
	 * @var ReservationReminderView|null
	 */
	public $EndReminder;

	/**
	 * @param AttributeValue $attribute
	 */
	public function AddAttribute(AttributeValue $attribute)
	{
		$this->Attributes[$attribute->AttributeId] = $attribute;
	}

	/**
	 * @param $attributeId int
	 * @return mixed
	 */
	public function GetAttributeValue($attributeId)
	{
		if (array_key_exists($attributeId, $this->Attributes))
		{
			return $this->Attributes[$attributeId]->Value;
		}

		return null;
	}

	/**
	 * @return bool
	 */
	public function IsRecurring()
	{
		return $this->RepeatType != RepeatType::None;
	}

	/**
	 * @return bool
	 */
	public function IsDisplayable()
	{
		return true; // some qualification should probably be made
	}

	/**
	 * @return bool
	 */
	public function RequiresApproval()
	{
		return $this->StatusId == ReservationStatus::Pending;
	}

	/**
	 * @param ReservationAttachmentView $attachment
	 */
	public function AddAttachment(ReservationAttachmentView $attachment)
	{
		$this->Attachments[] = $attachment;
	}
}

interface IReservedItemView
{
	/**
	 * @return Date
	 */
	public function GetStartDate();

	/**
	 * @return Date
	 */
	public function GetEndDate();

	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return mixed
	 */
	public function GetResourceName();

	/**
	 * @return int
	 */
	public function GetId();

	/**
	 * @param Date $date
	 * @return bool
	 */
	public function OccursOn(Date $date);

	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @return TimeInterval|null
	 */
	public function GetBufferTime();

	/**
	 * @return bool
	 */
	public function HasBufferTime();

	/**
	 * @return DateRange
	 */
	public function BufferedTimes();
}

class ReservationItemView implements IReservedItemView
{
	/**
	 * @var string
	 */
	public $ReferenceNumber;

	/**
	 * @var Date
	 */
	public $StartDate;

	/**
	 * @var Date
	 */
	public $EndDate;

	/**
	 * @var DateRange
	 */
	public $Date;

	/**
	 * @var string
	 */
	public $ResourceName;

	/**
	 * @var int
	 */
	public $ReservationId;

	/**
	 * @var int|ReservationUserLevel
	 */
	public $UserLevelId;

	/**
	 * @var string
	 */
	public $Title;

	/**
	 * @var string
	 */
	public $Description;

	/**
	 * @var int
	 */
	public $ScheduleId;

	/**
	 * @var null|string
	 */
	public $FirstName;

	/**
	 * @var null|string
	 */
	public $LastName;

	/**
	 * @var null|int
	 */
	public $UserId;

	/**
	 * @var null|Date
	 */
	public $CreatedDate;

	/**
	 * alias of $CreatedDate
	 * @var null|Date
	 */
	public $DateCreated;

	/**
	 * @var null|Date
	 */
	public $ModifiedDate;

	/**
	 * @var null|bool
	 */
	public $IsRecurring;

	/**
	 * @var null|bool
	 */
	public $RequiresApproval;

	/**
	 * @var string|RepeatType
	 */
	public $RepeatType;

	/**
	 * @var int
	 */

	public $RepeatInterval;
	/**
	 * @var array
	 */

	public $RepeatWeekdays;
	/**
	 * @var string|RepeatMonthlyType
	 */

	public $RepeatMonthlyType;
	/**
	 * @var Date
	 */

	public $RepeatTerminationDate;

	/**
	 * @var string
	 */
	public $OwnerEmailAddress;
	/**
	 * @var string
	 */
	public $OwnerPhone;
	/**
	 * @var string
	 */
	public $OwnerOrganization;
	/**
	 * @var string
	 */
	public $OwnerPosition;

	/**
	 * @var int
	 */
	public $SeriesId;

	/**
	 * @var array|int[]
	 */
	public $ParticipantIds = array();

	/**
	 * @var array|int[]
	 */
	public $InviteeIds = array();

	/**
	 * @var CustomAttributes
	 */
	public $Attributes;

	/**
	 * @var UserPreferences
	 */
	public $UserPreferences;

	/**
	 * @var int
	 */
	public $ResourceStatusId;

	/**
	 * @var int|null
	 */
	public $ResourceStatusReasonId;

	/**
	 * @var int|null
	 */
	private $bufferSeconds = 0;

	/**
	 * @param $referenceNumber string
	 * @param $startDate Date
	 * @param $endDate Date
	 * @param $resourceName string
	 * @param $resourceId int
	 * @param $reservationId int
	 * @param $userLevelId int|ReservationUserLevel
	 * @param $title string
	 * @param $description string
	 * @param $scheduleId int
	 * @param $userFirstName string
	 * @param $userLastName string
	 * @param $userId int
	 * @param $userPhone string
	 * @param $userPosition string
	 * @param $userOrganization string
	 * @param $participant_list string
	 * @param $invitee_list string
	 * @param $attribute_list string
	 * @param $preferences string
	 */
	public function __construct(
		$referenceNumber = null,
		$startDate = null,
		$endDate = null,
		$resourceName = null,
		$resourceId = null,
		$reservationId = null,
		$userLevelId = null,
		$title = null,
		$description = null,
		$scheduleId = null,
		$userFirstName = null,
		$userLastName = null,
		$userId = null,
		$userPhone = null,
		$userOrganization = null,
		$userPosition = null,
		$participant_list = null,
		$invitee_list = null,
		$attribute_list = null,
		$preferences = null
	)
	{
		$this->ReferenceNumber = $referenceNumber;
		$this->StartDate = $startDate;
		$this->EndDate = $endDate;
		$this->ResourceName = $resourceName;
		$this->ResourceId = $resourceId;
		$this->ReservationId = $reservationId;
		$this->Title = $title;
		$this->Description = $description;
		$this->ScheduleId = $scheduleId;
		$this->FirstName = $userFirstName;
		$this->OwnerFirstName = $userFirstName;
		$this->LastName = $userLastName;
		$this->OwnerLastName = $userLastName;
		$this->OwnerPhone = $userPhone;
		$this->OwnerOrganization = $userOrganization;
		$this->OwnerPosition = $userPosition;
		$this->UserId = $userId;
		$this->UserLevelId = $userLevelId;

		if (!empty($startDate) && !empty($endDate))
		{
			$this->Date = new DateRange($startDate, $endDate);
		}

		if (!empty($participant_list))
		{
			$this->ParticipantIds = explode(',', $participant_list);
		}

		if (!empty($invitee_list))
		{
			$this->InviteeIds = explode(',', $invitee_list);
		}

		$this->Attributes = CustomAttributes::Parse($attribute_list);
		$this->UserPreferences = UserPreferences::Parse($preferences);
	}

	/**
	 * @static
	 * @param $row array
	 * @return ReservationItemView
	 */
	public static function Populate($row)
	{
		$view = new ReservationItemView (
			$row[ColumnNames::REFERENCE_NUMBER],
			Date::FromDatabase($row[ColumnNames::RESERVATION_START]),
			Date::FromDatabase($row[ColumnNames::RESERVATION_END]),
			$row[ColumnNames::RESOURCE_NAME],
			$row[ColumnNames::RESOURCE_ID],
			$row[ColumnNames::RESERVATION_INSTANCE_ID],
			$row[ColumnNames::RESERVATION_USER_LEVEL],
			$row[ColumnNames::RESERVATION_TITLE],
			$row[ColumnNames::RESERVATION_DESCRIPTION],
			$row[ColumnNames::SCHEDULE_ID],
			$row[ColumnNames::OWNER_FIRST_NAME],
			$row[ColumnNames::OWNER_LAST_NAME],
			$row[ColumnNames::OWNER_USER_ID],
			$row[ColumnNames::OWNER_PHONE],
			$row[ColumnNames::OWNER_ORGANIZATION],
			$row[ColumnNames::OWNER_POSITION],
			$row[ColumnNames::PARTICIPANT_LIST],
			$row[ColumnNames::INVITEE_LIST],
			$row[ColumnNames::ATTRIBUTE_LIST],
			$row[ColumnNames::USER_PREFERENCES]
		);

		if (isset($row[ColumnNames::RESERVATION_CREATED]))
		{
			$view->CreatedDate = Date::FromDatabase($row[ColumnNames::RESERVATION_CREATED]);
			$view->DateCreated = Date::FromDatabase($row[ColumnNames::RESERVATION_CREATED]);
		}

		if (isset($row[ColumnNames::RESERVATION_MODIFIED]))
		{
			$view->ModifiedDate = Date::FromDatabase($row[ColumnNames::RESERVATION_MODIFIED]);
		}

		if (isset($row[ColumnNames::REPEAT_TYPE]))
		{
			$repeatConfig = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE],
														$row[ColumnNames::REPEAT_OPTIONS]);

			$view->RepeatType = $repeatConfig->Type;
			$view->RepeatInterval = $repeatConfig->Interval;
			$view->RepeatWeekdays = $repeatConfig->Weekdays;
			$view->RepeatMonthlyType = $repeatConfig->MonthlyType;
			$view->RepeatTerminationDate = $repeatConfig->TerminationDate;

			$view->IsRecurring = $row[ColumnNames::REPEAT_TYPE] != RepeatType::None;
		}

		if (isset($row[ColumnNames::RESERVATION_STATUS]))
		{
			$view->RequiresApproval = $row[ColumnNames::RESERVATION_STATUS] == ReservationStatus::Pending;
		}

		if (isset($row[ColumnNames::EMAIL]))
		{
			$view->OwnerEmailAddress = $row[ColumnNames::EMAIL];
		}

		if (isset($row[ColumnNames::SERIES_ID]))
		{
			$view->SeriesId = $row[ColumnNames::SERIES_ID];
		}

		if (isset($row[ColumnNames::RESOURCE_STATUS_REASON_ID]))
		{
			$view->ResourceStatusReasonId = $row[ColumnNames::RESOURCE_STATUS_REASON_ID];
		}

		if (isset($row[ColumnNames::RESOURCE_STATUS_ID_ALIAS]))
		{
			$view->ResourceStatusId = $row[ColumnNames::RESOURCE_STATUS_ID_ALIAS];
		}

		if (isset($row[ColumnNames::RESOURCE_BUFFER_TIME]))
		{
			$view->WithBufferTime($row[ColumnNames::RESOURCE_BUFFER_TIME]);
		}

		return $view;
	}

	/**
	 * @param Date $date
	 * @return bool
	 */
	public function OccursOn(Date $date)
	{
		return $this->Date->OccursOn($date);
	}

	/**
	 * @return Date
	 */
	public function GetStartDate()
	{
		return $this->StartDate;
	}

	/**
	 * @return Date
	 */
	public function GetEndDate()
	{
		return $this->EndDate;
	}

	/**
	 * @return int
	 */
	public function GetReservationId()
	{
		return $this->ReservationId;
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->ResourceId;
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->ReferenceNumber;
	}

	public function GetId()
	{
		return $this->GetReservationId();
	}

	/**
	 * @return DateDiff
	 */
	public function GetDuration()
	{
		return $this->StartDate->GetDifference($this->EndDate);
	}

	public function IsUserOwner($userId)
	{
		return $this->UserId == $userId && $this->UserLevelId == ReservationUserLevel::OWNER;
	}

	/**
	 * @param $userId int
	 * @return bool
	 */
	public function IsUserParticipating($userId)
	{
		return in_array($userId, $this->ParticipantIds);
	}

	/**
	 * @param $userId int
	 * @return bool
	 */
	public function IsUserInvited($userId)
	{
		return in_array($userId, $this->InviteeIds);
	}

	public function GetResourceName()
	{
		return $this->ResourceName;
	}

	/**
	 * @param int $seconds
	 */
	public function WithBufferTime($seconds)
	{
		$this->bufferSeconds = $seconds;
	}

	/**
	 * @return bool
	 */
	public function HasBufferTime()
	{
		return !empty($this->bufferSeconds);
	}

	/**
	 * @return TimeInterval
	 */
	public function GetBufferTime()
	{
		return TimeInterval::Parse($this->bufferSeconds);
	}

	/**
	 * @return DateRange
	 */
	public function BufferedTimes()
	{
		if (!$this->HasBufferTime())
		{
			return new DateRange($this->GetStartDate(), $this->GetEndDate());

		}

		$buffer = $this->GetBufferTime();
		return new DateRange($this->GetStartDate()->SubtractInterval($buffer), $this->GetEndDate()->AddInterval($buffer));
	}
}

class BlackoutItemView implements IReservedItemView
{
	/**
	 * @var Date
	 */
	public $StartDate;

	/**
	 * @var Date
	 */
	public $EndDate;

	/**
	 * @var DateRange
	 */
	public $Date;

	/**
	 * @var int
	 */
	public $ResourceId;

	/**
	 * @var string
	 */
	public $ResourceName;

	/**
	 * @var int
	 */
	public $InstanceId;

	/**
	 * @var int
	 */
	public $SeriesId;

	/**
	 * @var string
	 */
	public $Title;

	/**
	 * @var string
	 */
	public $Description;

	/**
	 * @var int
	 */
	public $ScheduleId;

	/**
	 * @var null|string
	 */
	public $FirstName;

	/**
	 * @var null|string
	 */
	public $LastName;

	/**
	 * @var null|int
	 */
	public $OwnerId;

	/**
	 * @var RepeatConfiguration
	 */
	public $RepeatConfiguration;

	/**
	 * @var bool
	 */
	public $IsRecurring;

	/**
	 * @param int $instanceId
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $resourceId
	 * @param int $ownerId
	 * @param int $scheduleId
	 * @param string $title
	 * @param string $description
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $resourceName
	 * @param int $seriesId
	 * @param string $repeatOptions
	 * @param string $repeatType
	 */
	public function __construct(
		$instanceId,
		Date $startDate,
		Date $endDate,
		$resourceId,
		$ownerId,
		$scheduleId,
		$title,
		$description,
		$firstName,
		$lastName,
		$resourceName,
		$seriesId,
		$repeatOptions,
		$repeatType)
	{
		$this->InstanceId = $instanceId;
		$this->StartDate = $startDate;
		$this->EndDate = $endDate;
		$this->ResourceId = $resourceId;
		$this->OwnerId = $ownerId;
		$this->ScheduleId = $scheduleId;
		$this->Title = $title;
		$this->Description = $description;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
		$this->ResourceName = $resourceName;
		$this->SeriesId = $seriesId;
		$this->Date = new DateRange($startDate, $endDate);
		$this->RepeatConfiguration = RepeatConfiguration::Create($repeatType, $repeatOptions);
		$this->IsRecurring = !empty($repeatType) && $repeatType != RepeatType::None;
	}

	/**
	 * @static
	 * @param $row
	 * @return BlackoutItemView
	 */
	public static function Populate($row)
	{
		return new BlackoutItemView($row[ColumnNames::BLACKOUT_INSTANCE_ID],
									Date::FromDatabase($row[ColumnNames::BLACKOUT_START]),
									Date::FromDatabase($row[ColumnNames::BLACKOUT_END]),
									$row[ColumnNames::RESOURCE_ID],
									$row[ColumnNames::USER_ID],
									$row[ColumnNames::SCHEDULE_ID],
									$row[ColumnNames::BLACKOUT_TITLE],
									$row[ColumnNames::BLACKOUT_DESCRIPTION],
									$row[ColumnNames::FIRST_NAME],
									$row[ColumnNames::LAST_NAME],
									$row[ColumnNames::RESOURCE_NAME],
									$row[ColumnNames::BLACKOUT_SERIES_ID],
									$row[ColumnNames::REPEAT_OPTIONS],
									$row[ColumnNames::REPEAT_TYPE]);
	}

	/**
	 * @return Date
	 */
	public function GetStartDate()
	{
		return $this->StartDate;
	}

	/**
	 * @return Date
	 */
	public function GetEndDate()
	{
		return $this->EndDate;
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->ResourceId;
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->InstanceId;
	}

	/**
	 * @param Date $date
	 * @return bool
	 */
	public function OccursOn(Date $date)
	{
		return $this->Date->OccursOn($date);
	}

	public function GetResourceName()
	{
		return $this->ResourceName;
	}

	public function GetReferenceNumber()
	{
		return '';
	}

	/**
	 * @return int|null
	 */
	public function GetBufferTime()
	{
		return null;
	}

	/**
	 * @return bool
	 */
	public function HasBufferTime()
	{
		return false;
	}

	/**
	 * @return DateRange
	 */
	public function BufferedTimes()
	{
		return new DateRange($this->GetStartDate(), $this->GetEndDate());
	}
}

class AccessoryReservation
{
	/**
	 * @var string
	 */
	private $referenceNumber;

	/**
	 * @var int
	 */
	private $accessoryId;

	/**
	 * @var \Date
	 */
	private $startDate;

	/**
	 * @var \Date
	 */
	private $endDate;

	/**
	 * @var int
	 */
	private $quantityReserved;

	/**
	 * @param string $referenceNumber
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param int $accessoryId
	 * @param int $quantityReserved
	 */
	public function __construct($referenceNumber, $startDate, $endDate, $accessoryId, $quantityReserved)
	{
		$this->referenceNumber = $referenceNumber;
		$this->accessoryId = $accessoryId;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->quantityReserved = $quantityReserved;
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->referenceNumber;
	}

	/**
	 * @return Date
	 */
	public function GetStartDate()
	{
		return $this->startDate;
	}

	/**
	 * @return Date
	 */
	public function GetEndDate()
	{
		return $this->endDate;
	}

	/**
	 * @return int
	 */
	public function GetAccessoryId()
	{
		return $this->accessoryId;
	}

	/**
	 * @return int
	 */
	public function QuantityReserved()
	{
		return $this->quantityReserved;
	}
}

class ReservationAttachmentView
{
	/**
	 * @param int $fileId
	 * @param int $seriesId
	 * @param string $fileName
	 */
	public function __construct($fileId, $seriesId, $fileName)
	{
		$this->fileId = $fileId;
		$this->seriesId = $seriesId;
		$this->fileName = $fileName;
	}

	/**
	 * @return int
	 */
	public function FileId()
	{
		return $this->fileId;
	}

	/**
	 * @return string
	 */
	public function FileName()
	{
		return $this->fileName;
	}

	/**
	 * @return int
	 */
	public function SeriesId()
	{
		return $this->seriesId;
	}
}

class ReservationReminderView
{
	/**
	 * @var int
	 */
	private $value;

	/**
	 * @var ReservationReminderInterval|string
	 */
	private $interval;

	/**
	 * @var int
	 */
	private $minutes;

	public function GetValue()
	{
		return $this->value;
	}

	public function GetInterval()
	{
		return $this->interval;
	}

	public function __construct($minutes)
	{
		$this->minutes = $minutes;
		if ($minutes % 1440 == 0)
		{
			$this->value = $minutes / 1440;
			$this->interval = ReservationReminderInterval::Days;
		}
		elseif ($minutes % 60 == 0)
		{
			$this->value = $minutes / 60;
			$this->interval = ReservationReminderInterval::Hours;
		}
		else
		{
			$this->value = $minutes;
			$this->interval = ReservationReminderInterval::Minutes;
		}
	}

	/**
	 * @return int
	 */
	public function MinutesPrior()
	{
		return $this->minutes;
	}
}

?>