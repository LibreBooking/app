<?php
/**
Copyright 2012-2015 Nick Korbel

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
								$lname = 'lname', $timezone = 'UTC', $reminder_minutes = 100, $language = 'en_us')
	{
		if (empty($startDate))
		{
			$startDate = Date::Now()->ToDatabase();
		}
		if (empty($endDate))
		{
			$endDate = Date::Now()->ToDatabase();
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
			ColumnNames::LANGUAGE_CODE => $language,
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
		$statusId,
		$allowParticipation
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
			ColumnNames::RESERVATION_STATUS => $statusId,
			ColumnNames::RESERVATION_ALLOW_PARTICIPATION => $allowParticipation,
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
								$scheduleId = null,
								$statusId = ResourceStatus::AVAILABLE)
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
		$this->statusId = $statusId;
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
			ColumnNames::RESOURCE_STATUS_ID => $this->statusId,
			ColumnNames::RESOURCE_IMAGE_NAME => null,
			ColumnNames::RESOURCE_ADMIN_GROUP_ID => null,
			ColumnNames::RESOURCE_STATUS_REASON_ID => null,
			ColumnNames::PUBLIC_ID => null,
			ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION => false,
			ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS => null,
			ColumnNames::RESOURCE_TYPE_ID => null,
			ColumnNames::RESOURCE_SORT_ORDER => null,
			ColumnNames::RESOURCE_BUFFER_TIME => null,
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

class ReservationReminderRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($reminderId, $seriesId, $minutesPrior = 15, $type = ReservationReminderType::Start)
	{
		$this->rows[] = array(
			ColumnNames::REMINDER_ID => $reminderId,
			ColumnNames::SERIES_ID => $seriesId,
			ColumnNames::REMINDER_MINUTES_PRIOR => $minutesPrior,
			ColumnNames::REMINDER_TYPE => $type);

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

class ResourceGroupRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($groupId, $groupName, $groupParentId = null)
	{
		$this->rows[] = array(
			ColumnNames::RESOURCE_GROUP_ID => $groupId,
			ColumnNames::RESOURCE_GROUP_NAME => $groupName,
			ColumnNames::RESOURCE_GROUP_PARENT_ID => $groupParentId
		);

		return $this;
	}
}

class ResourceGroupAssignmentRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($resourceId, $resourceName, $groupId)
	{
		$this->rows[] = array(
			ColumnNames::RESOURCE_GROUP_ID => $groupId,
			ColumnNames::RESOURCE_NAME => $resourceName,
			ColumnNames::RESOURCE_ID => $resourceId
		);

		return $this;
	}
}

class ResourceTypeRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($typeId, $name, $description = null)
	{
		$this->rows[] = array(
			ColumnNames::RESOURCE_TYPE_ID => $typeId,
			ColumnNames::RESOURCE_TYPE_NAME => $name,
			ColumnNames::RESOURCE_TYPE_DESCRIPTION => $description
		);

		return $this;
	}
}

class BlackoutSeriesRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($seriesId, $owner_id, $title = null, $repeatType = null, $repeatConfiguration = null, $currentStart = null, $currentEnd = null)
	{
		$start = !empty($currentStart) ? $currentStart->ToDatabase() : null;
		$end = !empty($currentEnd) ? $currentEnd->ToDatabase() : null;
		$this->rows[] = array(
			ColumnNames::BLACKOUT_SERIES_ID => $seriesId,
			ColumnNames::OWNER_USER_ID => $owner_id,
			ColumnNames::BLACKOUT_TITLE => $title,
			ColumnNames::REPEAT_TYPE => $repeatType,
			ColumnNames::REPEAT_OPTIONS => $repeatConfiguration,
			ColumnNames::BLACKOUT_START => $start,
			ColumnNames::BLACKOUT_END => $end,
			ColumnNames::BLACKOUT_INSTANCE_ID => 1
		);

		return $this;
	}
}

class BlackoutInstanceRow
{
	private $rows = array();

	public function Rows()
	{
		return $this->rows;
	}

	public function With($seriesId, $instance_id, $start_date, $end_date)
	{
		$this->rows[] = array(
			ColumnNames::BLACKOUT_SERIES_ID => $seriesId,
			ColumnNames::BLACKOUT_INSTANCE_ID => $instance_id,
			ColumnNames::BLACKOUT_START => $start_date,
			ColumnNames::BLACKOUT_END => $end_date,
		);

		return $this;
	}
}

class BlackoutResourceRow
{
	private $rows = array();

		public function Rows()
		{
			return $this->rows;
		}

		public function With($resourceId, $name, $scheduleId, $adminGroupId = null, $scheduleAdminGroupId = null)
		{
			$this->rows[] = array(
				ColumnNames::RESOURCE_ID => $resourceId,
				ColumnNames::RESOURCE_NAME => $name,
				ColumnNames::RESOURCE_ADMIN_GROUP_ID => $adminGroupId,
				ColumnNames::SCHEDULE_ID => $scheduleId,
				ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS => $scheduleAdminGroupId,
				ColumnNames::RESOURCE_STATUS_ID => ResourceStatus::AVAILABLE,
			);

			return $this;
		}
}

?>