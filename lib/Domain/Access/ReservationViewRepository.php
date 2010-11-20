<?php
interface IReservationViewRepository
{
	/*
	 * @var $referenceNumber string
	 */
	function GetReservationForEditing($referenceNumber);
}

class ReservationViewRepository implements IReservationViewRepository
{
	public function GetReservationForEditing($referenceNumber)
	{
		throw new Exception('not implemented');
	}
}

class ReservationView
{
	public $ReservationId;
	public $ReferenceNumber;
	public $ResourceId;
	public $ScheduleId;
	public $StartDate;
	public $EndDate;
	public $OwnerId;
	public $OwnerFirstName;
	public $OwnerLastName;
	public $Title;
	public $Description;
	
	public $AdditionalResourceIds;
	public $ParticipantIds;
}
?>