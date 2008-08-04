<?php
class ScheduleReservation
{
	public $ReservationId;
	public $StartDate;
	public $EndDate;
	public $StartTime;
	public $EndTime;
	public $ReservationType;
	public $Summary;
	public $ParentId;
	public $ResourceId;
	public $UserId;
	public $FirstName;
	public $LastName;		
		
	public function __construct(
							$reservationId,
							$startDate,
							$endDate,
							$startTime,
							$endTime,
							$reservationType,
							$summary,
							$parentId,
							$resourceId,
							$userId,
							$firstName,
							$lastName) 
	{
		$this->ReservationId = $reservationId;
		$this->StartDate = $startDate;
		$this->EndDate = $endDate;
		$this->StartTime = $startTime;
		$this->EndTime = $endTime;
		$this->ReservationType = $reservationType;
		$this->Summary = $summary;
		$this->ParentId = $parentId;
		$this->ResourceId = $resourceId;
		$this->UserId = $userId;
		$this->FirstName = $firstName;
		$this->LastName = $lastName;
	}
}


?>