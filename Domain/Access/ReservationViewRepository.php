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
			
			$repeatConfig = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE], $row[ColumnNames::REPEAT_OPTIONS]);
			
			$reservationView->RepeatType = $repeatConfig->Type;
			$reservationView->RepeatInterval = $repeatConfig->Interval;	
			$reservationView->RepeatWeekdays = $repeatConfig->Weekdays;	
			$reservationView->RepeatMonthlyType = $repeatConfig->MonthlyType;	
			$reservationView->RepeatTerminationDate = $repeatConfig->TerminationDate;	
		
			$resources = $this->GetResources($reservationView->SeriesId);
			$participants = $this->GetParticipants($reservationView->ReservationId);
			
			$reservationView->AdditionalResourceIds = $resources;
			$reservationView->ParticipantIds = $participants;
		}
		
		return $reservationView;
	}
	
	private function GetResources($seriesId)
	{
		$resources = array();
		
		$getResources = new GetReservationResourcesCommand($seriesId);
		
		$result = ServiceLocator::GetDatabase()->Query($getResources);
		
		while ($row = $result->GetRow())
		{
			$resources[] = $row[ColumnNames::RESOURCE_ID];
		}

		return $resources;
	}
	
	private function GetParticipants($reservationId)
	{
		$participants = array();
		$getParticipants = new GetReservationParticipantsCommand($reservationId);
		
		$result = ServiceLocator::GetDatabase()->Query($getParticipants);
		
		while ($row = $result->GetRow())
		{
			$participants[] = $row[ColumnNames::USER_ID];
		}
		
		return $participants;
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
	
	public $AdditionalResourceIds = array();
	public $ParticipantIds = array();
}
?>