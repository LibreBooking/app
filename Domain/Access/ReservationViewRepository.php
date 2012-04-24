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

require_once(ROOT_DIR . 'Domain/Values/ReservationUserLevel.php');
require_once(ROOT_DIR . 'Domain/Values/ReservationStatus.php');
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

            $repeatConfig = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE], $row[ColumnNames::REPEAT_OPTIONS]);

            $reservationView->RepeatType = $repeatConfig->Type;
            $reservationView->RepeatInterval = $repeatConfig->Interval;
            $reservationView->RepeatWeekdays = $repeatConfig->Weekdays;
            $reservationView->RepeatMonthlyType = $repeatConfig->MonthlyType;
            $reservationView->RepeatTerminationDate = $repeatConfig->TerminationDate;

            $this->SetResources($reservationView);
            $this->SetParticipants($reservationView);
            $this->SetAccessories($reservationView);
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
			$reservationView->Resources[] = new ReservationResourceView($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME], $row[ColumnNames::RESOURCE_ADMIN_GROUP_ID]);
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
            $reservationView->Accessories[] = new ReservationAccessory($row[ColumnNames::ACCESSORY_ID], $row[ColumnNames::QUANTITY], $row[ColumnNames::ACCESSORY_NAME]);
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

	public function __construct($resourceId, $resourceName = '', $adminGroupId)
    {
        $this->_id = $resourceId;
        $this->_resourceName = $resourceName;
        $this->_adminGroupId = $adminGroupId;
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
     * @var array|ReservationAccessory[]
     */
    public $Accessories = array();

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
}

interface IReservedItemView
{
    /**
     * @abstract
     * @return Date
     */
    public function GetStartDate();

    /**
     * @abstract
     * @return Date
     */
    public function GetEndDate();

    /**
     * @abstract
     * @return int
     */
    public function GetResourceId();

    /**
     * @abstract
     * @return int
     */
    public function GetId();

    /**
     * @abstract
     * @param Date $date
     * @return bool
     */
    public function OccursOn(Date $date);
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
	 * @var int
	 */
	public $SeriesId;

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
        $userId = null
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
        $this->LastName = $userLastName;
        $this->UserId = $userId;

        if (!is_null($startDate) && !is_null($endDate))
        {
            $this->Date = new DateRange($startDate, $endDate);
        }
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
            $row[ColumnNames::OWNER_USER_ID]
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
			$repeatConfig = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE], $row[ColumnNames::REPEAT_OPTIONS]);

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
        $seriesId)
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
            $row[ColumnNames::BLACKOUT_SERIES_ID]);
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

?>