<?php
/**
Copyright 2012 Nick Korbel

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
class CustomAttributeValueRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($attributeId, $value, $attributeLabel = null)
	{
		$this->rows[] = array(ColumnNames::ATTRIBUTE_ID => $attributeId,
			ColumnNames::ATTRIBUTE_VALUE => $value,
			ColumnNames::ATTRIBUTE_LABEL => $attributeLabel);

		return $this;
	}
}

class ReminderNoticeRow
{
	private $row = array();

	public function Rows()
	{
		return array($this->row);
	}

	public function __construct($seriesId = 1, $reservationId = 1, $referenceNumber = 'referencenumber',
								$startDate = null, $endDate = null, $title = 'title', $description = 'description',
								$resourceName = 'resourcename', $emailAddress = 'email@address.com', $fname = 'fname',
								$lname = 'lname', $timezone = 'UTC', $reminder_minutes = 100,
								$reminderDate = null)
	{
		if (empty($startDate))
		{
			$startDate = Date::Now()->ToDatabase();
		}
		if (empty($endDate))
		{
			$endDate = Date::Now()->ToDatabase();
		}
		if (empty($reminderDate))
		{
			$reminderDate = Date::Now()->ToDatabase();
		}
		$this->row = array(
			ColumnNames::SERIES_ID => $seriesId,
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId,
			ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::RESERVATION_START => $startDate,
			ColumnNames::RESERVATION_END => $endDate,
			ColumnNames::RESERVATION_TITLE => $title,
			ColumnNames::RESERVATION_DESCRIPTION => $description,
			ColumnNames::RESOURCE_NAME_ALIAS => $resourceName,
			ColumnNames::EMAIL => $emailAddress,
			ColumnNames::FIRST_NAME => $fname,
			ColumnNames::LAST_NAME => $lname,
			ColumnNames::TIMEZONE_NAME => $timezone,
			ColumnNames::REMINDER_MINUTES_PRIOR => $reminder_minutes,
			ColumnNames::REMINDER_DATE => $reminderDate,
		);
	}
}

class ReservationRow
{
	private $row = array();

	public function Rows()
	{
		return array($this->row);
	}

	public function __construct(
		$reservationId,
		$startDate,
		$endDate,
		$title,
		$description,
		$repeatType,
		$repeatOptions,
		$referenceNumber,
		$seriesId,
		$ownerId,
		$statusId
	)
	{
		$this->row = array(
			ColumnNames::RESERVATION_INSTANCE_ID => $reservationId,
			ColumnNames::RESERVATION_START => $startDate,
			ColumnNames::RESERVATION_END => $endDate,
			ColumnNames::RESERVATION_TITLE => $title,
			ColumnNames::RESERVATION_DESCRIPTION => $description,
			ColumnNames::RESERVATION_TYPE => ReservationTypes::Reservation,
			ColumnNames::REPEAT_TYPE => $repeatType,
			ColumnNames::REPEAT_OPTIONS => $repeatOptions,
			ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::SERIES_ID => $seriesId,
			ColumnNames::RESERVATION_OWNER => $ownerId,
			ColumnNames::RESERVATION_STATUS => $statusId
		);
	}
}

class ReservationInstanceRow
{
	private $seriesId;
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function __construct($seriesId)
	{
		$this->seriesId = $seriesId;
	}

	/**
	 * @param int $instanceId
	 * @param string $referenceNum
	 * @param DateRange $duration
	 * @return ReservationInstanceRow
	 */
	public function WithInstance($instanceId, $referenceNum, $duration)
	{
		$this->rows[] = array(
			ColumnNames::SERIES_ID => $this->seriesId,
			ColumnNames::RESERVATION_INSTANCE_ID => $instanceId,
			ColumnNames::REFERENCE_NUMBER => $referenceNum,
			ColumnNames::RESERVATION_START => $duration->GetBegin()->ToDatabase(),
			ColumnNames::RESERVATION_END => $duration->GetEnd()->ToDatabase(),
		);

		return $this;
	}
}

class ReservationResourceRow
{
	private $seriesId;
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function __construct($seriesId,
								$resourceName = null,
								$location = null,
								$contact = null,
								$notes = null,
								$minLength = null,
								$maxLength = null,
								$autoAssign = null,
								$requiresApproval = null,
								$allowMultiDay = null,
								$maxParticipants = null,
								$minNotice = null,
								$maxNotice = null,
								$scheduleId = null)
	{
		$this->seriesId = $seriesId;
		$this->resourceName = $resourceName;
		$this->location = $location;
		$this->contact = $contact;
		$this->notes = $notes;
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
		$this->autoAssign = $autoAssign;
		$this->requiresApproval = $requiresApproval;
		$this->allowMultiDay = $allowMultiDay;
		$this->maxParticipants = $maxParticipants;
		$this->minNotice = $minNotice;
		$this->maxNotice = $maxNotice;
		$this->scheduleId = $scheduleId;
		$this->description = null;
	}

	public function WithPrimary($resourceId)
	{
		$this->AddRow($resourceId, ResourceLevel::Primary);
		return $this;
	}

	public function WithAdditional($resourceId)
	{
		$this->AddRow($resourceId, ResourceLevel::Additional);
		return $this;
	}

	private function AddRow($resourceId, $levelId)
	{
		$this->rows[] = array(
			ColumnNames::SERIES_ID => $this->seriesId,
			ColumnNames::RESOURCE_ID => $resourceId,
			ColumnNames::RESOURCE_LEVEL_ID => $levelId,
			ColumnNames::RESOURCE_NAME => $this->resourceName,
			ColumnNames::RESOURCE_DESCRIPTION => $this->description,
			ColumnNames::RESOURCE_LOCATION => $this->location,
			ColumnNames::RESOURCE_CONTACT => $this->contact,
			ColumnNames::RESOURCE_NOTES => $this->notes,
			ColumnNames::RESOURCE_MINDURATION => $this->minLength,
			ColumnNames::RESOURCE_MAXDURATION => $this->maxLength,
			ColumnNames::RESOURCE_AUTOASSIGN => $this->autoAssign,
			ColumnNames::RESOURCE_REQUIRES_APPROVAL => $this->requiresApproval,
			ColumnNames::RESOURCE_ALLOW_MULTIDAY => $this->allowMultiDay,
			ColumnNames::RESOURCE_MAX_PARTICIPANTS => $this->maxParticipants,
			ColumnNames::RESOURCE_MINNOTICE => $this->minNotice,
			ColumnNames::RESOURCE_MAXNOTICE => $this->maxNotice,
			ColumnNames::SCHEDULE_ID => $this->scheduleId,
		);
	}
}

class ReservationUserRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	private function AddRow($referenceNumber, $userId, $levelId)
	{
		$this->rows[] = array(ColumnNames::REFERENCE_NUMBER => $referenceNumber,
			ColumnNames::USER_ID => $userId,
			ColumnNames::RESERVATION_USER_LEVEL => $levelId);
	}

	/**
	 * @param Reservation $instance
	 * @param array|int[] $participantIds
	 * @return ReservationUserRow
	 */
	public function WithParticipants($instance, $participantIds)
	{
		foreach ($participantIds as $id)
		{
			$this->AddRow($instance->ReferenceNumber(), $id, ReservationUserLevel::PARTICIPANT);
		}
		return $this;
	}

	/**
	 * @param Reservation $instance
	 * @param array|int[] $inviteeIds
	 * @return ReservationUserRow
	 */
	public function WithInvitees($instance, $inviteeIds)
	{
		foreach ($inviteeIds as $id)
		{
			$this->AddRow($instance->ReferenceNumber(), $id, ReservationUserLevel::INVITEE);
		}
		return $this;
	}
}


class ReservationAccessoryRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function WithAccessory($accessoryId, $quantityReserved, $name = null, $quantityAvailable = 0)
	{
		$this->rows[] = array(ColumnNames::ACCESSORY_ID => $accessoryId,
			ColumnNames::QUANTITY => $quantityReserved,
			ColumnNames::ACCESSORY_QUANTITY => $quantityAvailable,
			ColumnNames::ACCESSORY_NAME => $name);

		return $this;
	}
}

class ReservationAttachmentItemRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($fileId, $seriesId, $fileName = null, $extension = null)
	{
		$this->rows[] = array(ColumnNames::FILE_ID => $fileId,
			ColumnNames::SERIES_ID => $seriesId,
			ColumnNames::FILE_NAME => $fileName,
			ColumnNames::FILE_EXTENSION => $extension);

		return $this;
	}
}

class SavedReportRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($userId, $reportName, $dateCreated = null, $serialized = null, $reportId = 1)
	{
		$this->rows[] = array(ColumnNames::USER_ID => $userId,
			ColumnNames::REPORT_NAME => $reportName,
			ColumnNames::DATE_CREATED => $dateCreated,
			ColumnNames::REPORT_DETAILS => $serialized,
			ColumnNames::REPORT_ID => $reportId);

		return $this;
	}
}

class GroupItemRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($groupId, $groupName, $groupAdminName = 'group admin')
	{
		$this->rows[] = array(
			ColumnNames::GROUP_ID => $groupId,
			ColumnNames::GROUP_NAME => $groupName,
			ColumnNames::GROUP_ADMIN_GROUP_NAME => $groupAdminName
		);

		return $this;
	}
}

?>