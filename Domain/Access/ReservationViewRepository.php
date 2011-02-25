<?php
interface IReservationViewRepository
{
	/*
	 * @var $referenceNumber string
	 * @return ReservationView
	 */
	function GetReservationForEditing($referenceNumber);
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
			
			$repeatConfig = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE], $row[ColumnNames::REPEAT_OPTIONS]);
			
			$reservationView->RepeatType = $repeatConfig->Type;
			$reservationView->RepeatInterval = $repeatConfig->Interval;	
			$reservationView->RepeatWeekdays = $repeatConfig->Weekdays;	
			$reservationView->RepeatMonthlyType = $repeatConfig->MonthlyType;	
			$reservationView->RepeatTerminationDate = $repeatConfig->TerminationDate;	
		
			$this->SetResources($reservationView);
			$this->SetParticipants($reservationView);
			//$participants = $this->GetParticipants($reservationView->ReservationId);
			
			//$reservationView->ParticipantIds = $participants;
		}
		
		return $reservationView;
	}
	
	private function SetResources(ReservationView $reservationView)
	{
		$getResources = new GetReservationResourcesCommand($reservationView->SeriesId);
		
		$result = ServiceLocator::GetDatabase()->Query($getResources);
		
		while ($row = $result->GetRow())
		{
			$reservationView->AdditionalResourceIds[] = $row[ColumnNames::RESOURCE_ID];
			$reservationView->Resources[] = new ScheduleResource($row[ColumnNames::RESOURCE_ID], $row[ColumnNames::RESOURCE_NAME]);
		}
	}
	
	private function SetParticipants(ReservationView $reservationView)
	{
		$getParticipants = new GetReservationParticipantsCommand($reservationView->ReservationId);
		
		$result = ServiceLocator::GetDatabase()->Query($getParticipants);
		
		while ($row = $result->GetRow())
		{
			$reservationView->ParticipantIds[] = $row[ColumnNames::USER_ID];
			$reservationView->Participants[] = new ReservationUser(
					$row[ColumnNames::USER_ID], 
					$row[ColumnNames::FIRST_NAME], 
					$row[ColumnNames::LAST_NAME],
					$row[ColumnNames::EMAIL],
					$row[ColumnNames::RESERVATION_USER_LEVEL]);
		}
	}
}

class ReservationUser
{
	public $UserId;
	public $FirstName;
	public $LastName;
	public $Email;
	public $LevelId;
	
	public function __construct($userId, $firstName, $lastName, $email, $levelId)
	{
		$this->UserId = $userId;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
		$this->Email = $email;
		$this->LevelId = $levelId;
	}
	
	public function IsOwner()
	{
		return $this->LevelId == ReservationUserLevel::OWNER;
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
	 * @var ScheduleResource[]
	 */
	public $Resources = array();
	
	/**
	 * @var int[]
	 */
	public $ParticipantIds = array();
	
	/**
	 * @var ReservationUser[]
	 */
	public $Participants = array();
	
	public function IsRecurring()
	{
		return $this->RepeatType != RepeatType::None;
	}
	
	public function IsDisplayable()
	{
		return true;  // some qualification should probably be made
	}
	
}
?>