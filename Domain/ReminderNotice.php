<?php
/**
Copyright 2013-2020 Nick Korbel

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

class ReminderNotice
{
	private $seriesId;
	private $reservationId;
	private $referenceNumber;
	private $startDate;
	private $endDate;
	private $title;
	private $description;
	private $resourceNames;
	private $emailAddress;
	private $firstName;
	private $lastName;
	private $timezone;
	private $reminder_minutes;
	private $language;

	public function Description()
	{
		return $this->description;
	}

	public function EmailAddress()
	{
		return $this->emailAddress;
	}

	public function EndDate()
	{
		return $this->endDate;
	}

	public function FirstName()
	{
		return $this->firstName;
	}

	public function LastName()
	{
		return $this->lastName;
	}

	public function ReferenceNumber()
	{
		return $this->referenceNumber;
	}

	public function ReminderMinutes()
	{
		return $this->reminder_minutes;
	}

	public function ReservationId()
	{
		return $this->reservationId;
	}

	public function ResourceNames()
	{
		return $this->resourceNames;
	}

	public function SeriesId()
	{
		return $this->seriesId;
	}

	public function StartDate()
	{
		return $this->startDate;
	}

	public function Timezone()
	{
		return $this->timezone;
	}

	public function Title()
	{
		return $this->title;
	}

	public function Language()
	{
		return $this->language;
	}

	/**
	 * @param int $seriesId
	 * @param int $reservationId
	 * @param string $referenceNumber
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $title
	 * @param string $description
	 * @param string $resourceNames
	 * @param string $emailAddress
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $timezone
	 * @param int $reminder_minutes
	 * @param string $language
	 */
	public function __construct($seriesId, $reservationId, $referenceNumber, Date $startDate, Date $endDate, $title,
								$description, $resourceNames, $emailAddress, $firstName, $lastName, $timezone,
								$reminder_minutes, $language)
	{
		$this->seriesId = $seriesId;
		$this->reservationId = $reservationId;
		$this->referenceNumber = $referenceNumber;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->title = $title;
		$this->description = $description;
		$this->resourceNames = $resourceNames;
		$this->emailAddress = $emailAddress;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->timezone = $timezone;
		$this->reminder_minutes = $reminder_minutes;
		$this->language = $language;
	}

	/**
	 * @param array $row
	 * @return ReminderNotice
	 */
	public static function FromRow($row)
	{
		$seriesId = $row[ColumnNames::SERIES_ID];
		$reservationId = $row[ColumnNames::RESERVATION_INSTANCE_ID];
		$referenceNumber = $row[ColumnNames::REFERENCE_NUMBER];
		$startDate = Date::FromDatabase($row[ColumnNames::RESERVATION_START]);
		$endDate = Date::FromDatabase($row[ColumnNames::RESERVATION_END]);
		$title = $row[ColumnNames::RESERVATION_TITLE];
		$description = $row[ColumnNames::RESERVATION_DESCRIPTION];
		$resourceNames = str_replace('!sep!', ', ', $row[ColumnNames::RESOURCE_NAMES]);
		$emailAddress = $row[ColumnNames::EMAIL];
		$firstName = $row[ColumnNames::FIRST_NAME];
		$lastName = $row[ColumnNames::LAST_NAME];
		$timezone = $row[ColumnNames::TIMEZONE_NAME];
		$reminder_minutes = $row[ColumnNames::REMINDER_MINUTES_PRIOR];
		$language = $row[ColumnNames::LANGUAGE_CODE];

		return new ReminderNotice($seriesId, $reservationId, $referenceNumber,
								  $startDate, $endDate, $title, $description,
								  $resourceNames, $emailAddress, $firstName,
								  $lastName, $timezone, $reminder_minutes, $language);
	}
}