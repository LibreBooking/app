<?php
/**
 * Copyright 2011-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeResourceAccess extends ResourceRepository
{
	public $_GetForScheduleCalled = false;
	public $_LastScheduleId;
	public $_Resources = array();
	private $rows = array();

	public function __construct()
	{
		$this->FillRows();
	}

	public function GetScheduleResources($scheduleId)
	{
		$this->_GetForScheduleCalled = true;
		$this->_LastScheduleId = $scheduleId;

		return $this->_Resources;
	}

	private function FillRows()
	{
		$rows = $this->GetRows();
		foreach ($rows as $row)
		{
			$this->_Resources[] = BookableResource::Create($row);
		}
	}

	public function Rows()
	{
		return $this->rows;
	}

	public function With($id,
						 $name,
						 $location = null,
						 $contact = null,
						 $notes = null,
						 $minDuration = null,
						 $maxDuration = null,
						 $autoAssign = 0,
						 $approval = 0,
						 $multiDay = 0,
						 $participants = null,
						 $minNotice = null,
						 $maxNotice = null,
						 $description = null,
						 $scheduleId = 1,
						 $image = null,
						 $adminGroup = null,
						 $allowSubscription = 0,
						 $publicId = null,
						 $scheduleAdminId = null,
						 $sortOrder = 1,
						 $typeId = null,
						 $statusId = ResourceStatus::AVAILABLE,
						 $reasonId = null,
						 $bufferTime = null,
						 $color = null,
						 $enableCheckin = null,
						 $autoReleaseMinutes = null,
						 $creditCount = null,
						 $peakCreditCount = null
	)
	{

		$this->rows[] = array(ColumnNames::RESOURCE_ID => $id,
				ColumnNames::RESOURCE_NAME => $name,
				ColumnNames::RESOURCE_LOCATION => $location,
				ColumnNames::RESOURCE_CONTACT => $contact,
				ColumnNames::RESOURCE_NOTES => $notes,
				ColumnNames::RESOURCE_MINDURATION => $minDuration,
				ColumnNames::RESOURCE_MAXDURATION => $maxDuration,
				ColumnNames::RESOURCE_AUTOASSIGN => $autoAssign,
				ColumnNames::RESOURCE_REQUIRES_APPROVAL => $approval,
				ColumnNames::RESOURCE_ALLOW_MULTIDAY => $multiDay,
				ColumnNames::RESOURCE_MAX_PARTICIPANTS => $participants,
				ColumnNames::RESOURCE_MINNOTICE => $minNotice,
				ColumnNames::RESOURCE_MAXNOTICE => $maxNotice,
				ColumnNames::RESOURCE_DESCRIPTION => $description,
				ColumnNames::SCHEDULE_ID => $scheduleId,
				ColumnNames::RESOURCE_IMAGE_NAME => $image,
				ColumnNames::RESOURCE_ADMIN_GROUP_ID => $adminGroup,
				ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION => $allowSubscription,
				ColumnNames::PUBLIC_ID => $publicId,
				ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS => $scheduleAdminId,
				ColumnNames::RESOURCE_SORT_ORDER => $sortOrder,
				ColumnNames::RESOURCE_TYPE_ID => $typeId,
				ColumnNames::RESOURCE_STATUS_ID => $statusId,
				ColumnNames::RESOURCE_STATUS_REASON_ID => $reasonId,
				ColumnNames::RESOURCE_BUFFER_TIME => $bufferTime,
				ColumnNames::RESOURCE_GROUP_LIST => '1!sep!2',
				ColumnNames::RESERVATION_COLOR => $color,
				ColumnNames::ENABLE_CHECK_IN => $enableCheckin,
				ColumnNames::AUTO_RELEASE_MINUTES => $autoReleaseMinutes,
				ColumnNames::CREDIT_COUNT => $creditCount,
				ColumnNames::PEAK_CREDIT_COUNT => $peakCreditCount,
		);

		return $this;
	}

	public function GetRows()
	{
		$this->With(1, 'resource 1', null, null, 'notes 1', null, null, 0, 0, 0, null, null, null, null, 10, null, null,
					1, '1232', 1154, 1, 10, ResourceStatus::AVAILABLE, null, 60 * 30, '000000', true, 20);

		$this->With(2, 'resource 2',
					'here 2',
					'2',
					'notes 1',
					10,
					100,
					1,
					1,
					1,
					10,
					30,
					400,
					null,
					11,
					'something.gif',
					1,
					0,
					null,
					9292,
					null,
					null,
					ResourceStatus::UNAVAILABLE,
					98,
					null
		);

		return $this->rows;
	}
}