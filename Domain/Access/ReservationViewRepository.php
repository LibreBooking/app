<?php
require_once(ROOT_DIR . 'Domain/Values/ReservationUserLevel.php');
require_once(ROOT_DIR . 'Domain/Values/ReservationStatus.php');
require_once(ROOT_DIR . 'Domain/RepeatOptions.php');

interface IReservationViewRepository
{
	/**
	 * @var $referenceNumber string
	 * @return ReservationView
	 */
	function GetReservationForEditing($referenceNumber);
	
	/**
	 * @param $startDate Date
	 * @param $endDate Date
	 * @param $userId int
	 * @param $userLevel int|ReservationUserLevel
	 * @return ReservationItemView[]
	 */
	function GetReservationList(Date $startDate, Date $endDate, $userId,  $userLevel = ReservationUserLevel::OWNER);

	/**
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
	 * @return array|AccessoryReservation[]
	 */
	public function GetAccessoriesWithin(DateRange $dateRange);
}

class ReservationViewRepository implements IReservationViewRepository
{
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
			$reservationView->ReferenceNumber = $row[ColumnNames::REFERENCE_NUMBER];
			$reservationView->ReservationId = $row[ColumnNames::RESERVATION_INSTANCE_ID];
			$reservationView->ScheduleId = $row[ColumnNames::SCHEDULE_ID];
			$reservationView->StartDate = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
			$reservationView->Title = $row[ColumnNames::RESERVATION_TITLE];	
			$reservationView->SeriesId = $row[ColumnNames::SERIES_ID];	
			$reservationView->OwnerFirstName = $row[ColumnNames::FIRST_NAME];	
			$reservationView->OwnerLastName = $row[ColumnNames::LAST_NAME];
			$reservationView->StatusId = $row[ColumnNames::RESERVATION_STATUS];

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
	
	public function GetReservationList(Date $startDate, Date $endDate, $userId, $userLevel = ReservationUserLevel::OWNER)
	{
		$getReservations = new GetReservationListCommand($startDate, $endDate, $userId, $userLevel);
		
		$result = ServiceLocator::GetDatabase()->Query($getReservations);
		
		$reservations = array();

		while ($row = $result->GetRow())
		{
			$reservations[] = ReservationItemView::Populate($row);
		}
		
		$result->Free();
		
		return $reservations;
	}

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param null|string $sortField
	 * @param null|string $sortDirection
	 * @param null|ISqlFilter $filter
	 * @return PageableData|ReservationItemView[]
	 */
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
			$reservationView->Resources[] = new ReservationResourceView($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
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

	/**
	 * @param DateRange $dateRange
	 * @return array|AccessoryReservation[]
	 */
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

		return $accessories;
	}
}

class ReservationResourceView
{
	private $_id;
	private $_resourceName;
	
	public function __construct($resourceId, $resourceName = '')
	{
		$this->_id = $resourceId;
	}
	
	public function Id()
	{
		return $this->_id;
	}
	
	public function Name()
	{
		return $this->_resourceName;
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
	{}
	
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
	public $OwnerId;
	public $OwnerFirstName;
	public $OwnerLastName;
	public $Title;
	public $Description;
	public $RepeatType;
	public $RepeatInterval;
	public $RepeatWeekdays;
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
		return true;  // some qualification should probably be made
	}

	/**
	 * @return bool
	 */
	public function RequiresApproval()
	{
		return $this->StatusId == ReservationStatus::Pending;
	}
}

class ReservationItemView
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
					$row[ColumnNames::FIRST_NAME],
					$row[ColumnNames::LAST_NAME],
					$row[ColumnNames::USER_ID]
		);

		if (isset($row[ColumnNames::RESERVATION_CREATED]))
		{
			$view->CreatedDate = Date::FromDatabase($row[ColumnNames::RESERVATION_CREATED]);
		}

		if (isset($row[ColumnNames::RESERVATION_MODIFIED]))
		{
			$view->ModifiedDate = Date::FromDatabase($row[ColumnNames::RESERVATION_MODIFIED]);
		}

		if (isset($row[ColumnNames::REPEAT_TYPE]))
		{
			$view->IsRecurring = $row[ColumnNames::REPEAT_TYPE] != RepeatType::None;
		}

		if (isset($row[ColumnNames::RESERVATION_STATUS]))
		{
			$view->RequiresApproval = $row[ColumnNames::RESERVATION_STATUS] == ReservationStatus::Pending;
		}

		return $view;
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