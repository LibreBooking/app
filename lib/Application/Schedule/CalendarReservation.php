<?php

/**
 * Copyright 2011-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
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

	/**
	 * @var string
	 */
	public $OwnerFirst;

	/**
	 * @var string
	 */
	public $OwnerLast;

	/**
	 * @var string
	 */
	public $DisplayTitle;

	/**
	 * @var string
	 */
	public $Color;

	/**
	 * @var string
	 */
	public $TextColor;

	/**
	 * @var string
	 */
	public $Class;

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
	 * @param $user UserSession
	 * @param $groupSeriesByResource bool
	 * @return array|CalendarReservation[]
	 */
	public static function FromViewList($reservations, $timezone, $user, $groupSeriesByResource = false)
	{
		$knownSeries = array();
		$results = array();

		foreach ($reservations as $reservation)
		{
			if ($groupSeriesByResource)
			{
				if (array_key_exists($reservation->ReferenceNumber, $knownSeries))
				{
					continue;
				}
				$knownSeries[$reservation->ReferenceNumber] = true;
			}
			$results[] = self::FromView($reservation, $timezone, $user);
		}
		return $results;
	}

	/**
	 * @param $reservation ReservationItemView
	 * @param $timezone string
	 * @param $user UserSession
	 * @return CalendarReservation
	 */
	public static function FromView($reservation, $timezone, $user)
	{
		$factory = new SlotLabelFactory($user);
		$start = $reservation->StartDate->ToTimezone($timezone);
		$end = $reservation->EndDate->ToTimezone($timezone);
		$resourceName = $reservation->ResourceName;
		$referenceNumber = $reservation->ReferenceNumber;

		$res = new CalendarReservation($start, $end, $resourceName, $referenceNumber);

		$res->Title = $reservation->Title;
		$res->Description = $reservation->Description;
		$res->DisplayTitle = $factory->Format($reservation, Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_LABELS,
																									 ConfigKeys::RESERVATION_LABELS_MY_CALENDAR));
		$res->Invited = $reservation->UserLevelId == ReservationUserLevel::INVITEE;
		$res->Participant = $reservation->UserLevelId == ReservationUserLevel::PARTICIPANT;
		$res->Owner = $reservation->UserLevelId == ReservationUserLevel::OWNER;

		$color = $reservation->UserPreferences->Get(UserPreferences::RESERVATION_COLOR);
		if (!empty($color))
		{
			$res->Color = "#$color";
			$res->TextColor = new ContrastingColor($color);
		}

		$res->Class = self::GetClass($reservation);

		return $res;
	}

	/**
	 * @static
	 * @param array|ReservationItemView[] $reservations
	 * @param array|ResourceDto[] $resources
	 * @param UserSession $userSession
	 * @param bool $groupSeriesByResource
	 * @return array|CalendarReservation[]
	 */
	public static function FromScheduleReservationList($reservations, $resources, UserSession $userSession, $groupSeriesByResource = false)
	{
		$knownSeries = array();
		$factory = new SlotLabelFactory($userSession);

		$resourceMap = array();
		/** @var $resource ResourceDto */
		foreach ($resources as $resource)
		{
			$resourceMap[$resource->GetResourceId()] = $resource->GetName();
		}

		$res = array();
		foreach ($reservations as $reservation)
		{
			if (!array_key_exists($reservation->ResourceId, $resourceMap))
			{
				continue;
			}

			if ($groupSeriesByResource)
			{
				if (array_key_exists($reservation->ReferenceNumber, $knownSeries))
				{
					continue;
				}
				$knownSeries[$reservation->ReferenceNumber] = true;
			}

			$timezone = $userSession->Timezone;
			$start = $reservation->StartDate->ToTimezone($timezone);
			$end = $reservation->EndDate->ToTimezone($timezone);
			$referenceNumber = $reservation->ReferenceNumber;

			$cr = new CalendarReservation($start, $end, $resourceMap[$reservation->ResourceId], $referenceNumber);
			$cr->Title = $reservation->Title;
			$cr->OwnerName = new FullName($reservation->FirstName, $reservation->LastName);
			$cr->OwnerFirst = $reservation->FirstName;
			$cr->OwnerLast = $reservation->LastName;
			$cr->DisplayTitle = $factory->Format($reservation, Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_LABELS,
																										ConfigKeys::RESERVATION_LABELS_RESOURCE_CALENDAR));

			$color = $reservation->UserPreferences->Get(UserPreferences::RESERVATION_COLOR);
			if (!empty($color))
			{
				$cr->Color = "#$color";
				$cr->TextColor = new ContrastingColor($color);
			}

			$cr->Class = self::GetClass($reservation);

			$res[] = $cr;
		}

		return $res;
	}

	private static function GetClass(ReservationItemView $reservation)
	{
		if ($reservation->RequiresApproval)
		{
			return 'reserved pending';
		}

		$user = ServiceLocator::GetServer()->GetUserSession();

		if ($reservation->IsUserOwner($user->UserId))
		{
			return 'reserved mine';
		}

		if ($reservation->IsUserParticipating($user->UserId))
		{
			return 'reserved participating';
		}

		return 'reserved';

	}
}

?>