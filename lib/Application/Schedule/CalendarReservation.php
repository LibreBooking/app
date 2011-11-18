<?php
class CalendarReservation
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
	 * @var string
	 */
	public $ResourceName;

	/**
	 * @var string
	 */
	public $ReferenceNumber;

	/**
	 * @var string
	 */
	public $Title;

	/**
	 * @var string
	 */
	public $Description;

	/**
	 * @var bool
	 */
	public $Invited;

	/**
	 * @var bool
	 */
	public $Participant;

	/**
	 * @var bool
	 */
	public $Owner;

	/**
	 * @var string
	 */
	public $OwnerName;

	private function __construct(Date $startDate, Date $endDate, $resourceName, $referenceNumber)
	{
		$this->StartDate = $startDate;
		$this->EndDate = $endDate;
		$this->ResourceName = $resourceName;
		$this->ReferenceNumber = $referenceNumber;
	}

	/**
	 * @param $reservations array|ReservationItemView[]
	 * @param $timezone string
	 * @return array|CalendarReservation[]
	 */
	public static function FromViewList($reservations, $timezone)
	{
		$results = array();

		foreach ($reservations as $reservation)
		{
			$results[] = self::FromView($reservation, $timezone);
		}
		return $results;
	}

	/**
	 * @param $reservation ReservationItemView
	 * @param $timezone string
	 * @return CalendarReservation
	 */
	public static function FromView($reservation, $timezone)
	{
		$start = $reservation->StartDate->ToTimezone($timezone);
		$end = $reservation->EndDate->ToTimezone($timezone);
		$resourceName = $reservation->ResourceName;
		$referenceNumber = $reservation->ReferenceNumber;

		$res = new CalendarReservation($start, $end, $resourceName, $referenceNumber);

		$res->Title = $reservation->Title;
		$res->Description = $reservation->Description;

		$res->Invited = $reservation->UserLevelId == ReservationUserLevel::INVITEE;
		$res->Participant = $reservation->UserLevelId == ReservationUserLevel::PARTICIPANT;
		$res->Owner = $reservation->UserLevelId == ReservationUserLevel::OWNER;
		return $res;
	}

	/**
	 * @static
	 * @param $reservations array|ReservationItemView[]
	 * @param $resources array|BookableResources[]
	 * @param $timezone string
	 * @return array|CalendarReservation[]
	 */
	public static function FromScheduleReservationList($reservations, $resources, $timezone)
	{
		$resourceMap = array();
		/** @var $resource BookableResource */
		foreach ($resources as $resource)
		{
			$resourceMap[$resource->GetResourceId()] = $resource->GetName();
		}
		
		$res = array();
		foreach ($reservations as $reservation)
		{
			$start = $reservation->StartDate->ToTimezone($timezone);
			$end = $reservation->EndDate->ToTimezone($timezone);
			$referenceNumber = $reservation->ReferenceNumber;

			$cr = new CalendarReservation($start, $end, $resourceMap[$reservation->ResourceId], $referenceNumber);
			$cr->OwnerName = $reservation->FirstName . ' ' . $reservation->LastName;
			$res[] = $cr;
		}

		return $res;
	}
}

?>