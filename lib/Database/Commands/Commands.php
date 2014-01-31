<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Database/SqlCommand.php');

class AddAccessoryCommand extends SqlCommand
{
	public function __construct($accessoryName, $quantityAvailable)
	{
		parent::__construct(Queries::ADD_ACCESSORY);
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_NAME, $accessoryName));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_QUANTITY, $quantityAvailable));
	}
}

class AddAccountActivationCommand extends SqlCommand
{
	public function __construct($userId, $activationCode)
	{
		parent::__construct(Queries::ADD_ACCOUNT_ACTIVATION);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::ACTIVATION_CODE, $activationCode));
		$this->AddParameter(new Parameter(ParameterNames::DATE_CREATED, Date::Now()
																		->ToDatabase()));
	}
}

class AddAnnouncementCommand extends SqlCommand
{
	public function __construct($text, Date $start, Date $end, $priority)
	{
		parent::__construct(Queries::ADD_ANNOUNCEMENT);
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_TEXT, $text));
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $start->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $end->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_PRIORITY, $priority));
	}
}

class AddAttributeCommand extends SqlCommand
{
	public function __construct($label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId)
	{
		parent::__construct(Queries::ADD_ATTRIBUTE);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_LABEL, $label));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_TYPE, (int)$type));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, (int)$category));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_REGEX, $regex));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_REQUIRED, (int)$required));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_POSSIBLE_VALUES, $possibleValues));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_SORT_ORDER, $sortOrder));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ENTITY_ID, $entityId));
	}
}

class AddAttributeValueCommand extends SqlCommand
{
	public function __construct($attributeId, $value, $entityId, $attributeCategory)
	{
		parent::__construct(Queries::ADD_ATTRIBUTE_VALUE);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ID, $attributeId));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_VALUE, $value));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ENTITY_ID, $entityId));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, $attributeCategory));
	}
}

class AddBlackoutCommand extends SqlCommand
{
	public function __construct($userId, $title, $repeatTypeId, $repeatTypeConfiguration)
	{
		parent::__construct(Queries::ADD_BLACKOUT_SERIES);
		$this->AddParameter(new Parameter(ParameterNames::DATE_CREATED, Date::Now()->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::TITLE, $title));
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_TYPE, $repeatTypeId));
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_OPTIONS, $repeatTypeConfiguration));
	}
}

class AddBlackoutInstanceCommand extends SqlCommand
{
	public function __construct($blackoutSeriesId, Date $startDate, Date $endDate)
	{
		parent::__construct(Queries::ADD_BLACKOUT_INSTANCE);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $blackoutSeriesId));
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
	}
}

class AddBlackoutResourceCommand extends SqlCommand
{
	public function __construct($blackoutSeriesId, $resourceId)
	{
		parent::__construct(Queries::ADD_BLACKOUT_RESOURCE);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $blackoutSeriesId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class AddEmailPreferenceCommand extends SqlCommand
{
	public function __construct($userId, $eventCategory, $eventType)
	{
		parent::__construct(Queries::ADD_EMAIL_PREFERENCE);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::EVENT_CATEGORY, $eventCategory));
		$this->AddParameter(new Parameter(ParameterNames::EVENT_TYPE, $eventType));
	}
}

class AddGroupCommand extends SqlCommand
{
	public function __construct($groupName)
	{
		parent::__construct(Queries::ADD_GROUP);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_NAME, $groupName));
	}
}

class AddGroupResourcePermission extends SqlCommand
{
	public function __construct($groupId, $resourceId)
	{
		parent::__construct(Queries::ADD_GROUP_RESOURCE_PERMISSION);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class AddGroupRoleCommand extends SqlCommand
{
	public function __construct($groupId, $roleId)
	{
		parent::__construct(Queries::ADD_GROUP_ROLE);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::ROLE_ID, $roleId));
	}
}

class AddLayoutCommand extends SqlCommand
{
	public function __construct($timezone)
	{
		parent::__construct(Queries::ADD_LAYOUT);
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_NAME, $timezone));
	}
}

class AddLayoutTimeCommand extends SqlCommand
{
	public function __construct($layoutId, Time $start, Time $end, $periodType, $label = null, $dayOfWeek = null)
	{
		parent::__construct(Queries::ADD_LAYOUT_TIME);
		$this->AddParameter(new Parameter(ParameterNames::LAYOUT_ID, $layoutId));
		$this->AddParameter(new Parameter(ParameterNames::START_TIME, $start->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_TIME, $end->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::PERIOD_AVAILABILITY_TYPE, $periodType));
		$this->AddParameter(new Parameter(ParameterNames::PERIOD_LABEL, $label));
		$this->AddParameter(new Parameter(ParameterNames::PERIOD_DAY_OF_WEEK, $dayOfWeek));
	}
}

class AddQuotaCommand extends SqlCommand
{
	public function __construct($duration, $limit, $unit, $resourceId, $groupId, $scheduleId)
	{
		parent::__construct(Queries::ADD_QUOTA);
		$this->AddParameter(new Parameter(ParameterNames::QUOTA_DURATION, $duration));
		$this->AddParameter(new Parameter(ParameterNames::QUOTA_LIMIT, $limit));
		$this->AddParameter(new Parameter(ParameterNames::QUOTA_UNIT, $unit));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class AddReservationSeriesCommand extends SqlCommand
{
	public function __construct(Date $dateCreated,
								$title,
								$description,
								$repeatType,
								$repeatOptions,
								$reservationTypeId,
								$statusId,
								$ownerId
	)
	{
		parent::__construct(Queries::ADD_RESERVATION_SERIES);

		$this->AddParameter(new Parameter(ParameterNames::DATE_CREATED, $dateCreated->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::TITLE, $title));
		$this->AddParameter(new Parameter(ParameterNames::DESCRIPTION, $description));
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_TYPE, $repeatType));
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_OPTIONS, $repeatOptions));
		$this->AddParameter(new Parameter(ParameterNames::TYPE_ID, $reservationTypeId));
		$this->AddParameter(new Parameter(ParameterNames::STATUS_ID, $statusId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $ownerId));
	}
}

class AddReservationAccessoryCommand extends SqlCommand
{
	public function __construct($accessoryId, $quantity, $seriesId)
	{
		parent::__construct(Queries::ADD_RESERVATION_ACCESSORY);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $accessoryId));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_QUANTITY, $quantity));
	}
}

class AddReservationAttachmentCommand extends SqlCommand
{
	public function __construct($fileName, $fileType, $fileSize, $fileExtension, $seriesId)
	{
		parent::__construct(Queries::ADD_RESERVATION_ATTACHMENT);

		$this->AddParameter(new Parameter(ParameterNames::FILE_NAME, $fileName));
		$this->AddParameter(new Parameter(ParameterNames::FILE_TYPE, $fileType));
		$this->AddParameter(new Parameter(ParameterNames::FILE_SIZE, $fileSize));
		$this->AddParameter(new Parameter(ParameterNames::FILE_EXTENSION, $fileExtension));
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class AddReservationReminderCommand extends SqlCommand
{
	public function __construct($seriesId, $minutesPrior, $reminderType)
	{
		parent::__construct(Queries::ADD_RESERVATION_REMINDER);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_MINUTES_PRIOR, $minutesPrior));
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_TYPE, $reminderType));
	}
}

class AddReservationResourceCommand extends SqlCommand
{
	public function __construct($seriesId, $resourceId, $resourceLevelId)
	{
		parent::__construct(Queries::ADD_RESERVATION_RESOURCE);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LEVEL_ID, $resourceLevelId));
	}
}

class AddReservationCommand extends SqlCommand
{
	public function __construct(Date $startDate,
								Date $endDateUtc,
								$referenceNumber,
								$seriesId)
	{
		parent::__construct(Queries::ADD_RESERVATION);
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDateUtc->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class AddReservationUserCommand extends SqlCommand
{
	public function __construct($instanceId, $userId, $levelId)
	{
		parent::__construct(Queries::ADD_RESERVATION_USER);

		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $instanceId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_USER_LEVEL_ID, $levelId));
	}
}

class AddResourceCommand extends SqlCommand
{
	public function __construct($name, $schedule_id, $autoassign = 1, $admin_group_id = null,
								$location = null, $contact_info = null, $description = null, $notes = null,
								$status_id = 1, $min_duration = null, $min_increment = null, $max_duration = null,
								$unit_cost = null, $requires_approval = 0, $allow_multiday = 1,
								$max_participants = null, $min_notice_time = null, $max_notice_time = null)
	{
		parent::__construct(Queries::ADD_RESOURCE);

		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $schedule_id));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LOCATION, $location));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_CONTACT, $contact_info));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_DESCRIPTION, $description));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NOTES, $notes));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS, $status_id));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MINDURATION, $min_duration));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MININCREMENT, $min_increment));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAXDURATION, $max_duration));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_COST, $unit_cost));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_AUTOASSIGN, (int)$autoassign));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_REQUIRES_APPROVAL, $requires_approval));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ALLOW_MULTIDAY, $allow_multiday));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAX_PARTICIPANTS, $max_participants));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MINNOTICE, $min_notice_time));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAXNOTICE, $max_notice_time));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ADMIN_ID, $admin_group_id));
	}
}

class AddResourceGroupCommand extends SqlCommand
{
	public function __construct($groupName, $parentId = null)
	{
		parent::__construct(Queries::ADD_RESOURCE_GROUP);

		$this->AddParameter(new Parameter(ParameterNames::GROUP_NAME, $groupName));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_ID, empty($parentId) ? null : $parentId));
	}
}

class AddResourceStatusReasonCommand extends SqlCommand
{
	public function __construct($statusId, $reasonDescription)
		{
			parent::__construct(Queries::ADD_RESOURCE_STATUS_REASON);

			$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS, $statusId));
			$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS_REASON_DESCRIPTION, $reasonDescription));
		}
}

class AddResourceToGroupCommand extends SqlCommand
{
	public function __construct($resourceId, $groupId)
	{
		parent::__construct(Queries::ADD_RESOURCE_TO_GROUP);

		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_ID, $groupId));
	}
}

class AddResourceTypeCommand extends SqlCommand
{
	public function __construct($name, $description)
	{
		parent::__construct(Queries::ADD_RESOURCE_TYPE);

		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_DESCRIPTION, $description));
	}
}

class AddSavedReportCommand extends SqlCommand
{
	public function __construct($reportName, $userId, Date $dateCreated, $serializedCriteria)
	{
		parent::__construct(Queries::ADD_SAVED_REPORT);
		$this->AddParameter(new Parameter(ParameterNames::REPORT_NAME, $reportName));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::DATE_CREATED, $dateCreated->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::REPORT_DETAILS, $serializedCriteria));
	}
}

class AddScheduleCommand extends SqlCommand
{
	public function __construct($scheduleName, $isDefault, $weekdayStart, $daysVisible, $layoutId, $adminGroupId = null)
	{
		parent::__construct(Queries::ADD_SCHEDULE);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_NAME, $scheduleName));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ISDEFAULT, (int)$isDefault));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_WEEKDAYSTART, $weekdayStart));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_DAYSVISIBLE, $daysVisible));
		$this->AddParameter(new Parameter(ParameterNames::LAYOUT_ID, $layoutId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ADMIN_ID, $adminGroupId));
	}
}

class AddUserGroupCommand extends SqlCommand
{
	public function __construct($userId, $groupId)
	{
		parent::__construct(Queries::ADD_USER_GROUP);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
	}
}

class AddUserResourcePermission extends SqlCommand
{
	public function __construct($userId, $resourceId)
	{
		parent::__construct(Queries::ADD_USER_RESOURCE_PERMISSION);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class AddUserSessionCommand extends SqlCommand
{
	public function __construct($userId, $token, Date $insertTime, $serializedSession)
	{
		parent::__construct(Queries::ADD_USER_SESSION);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::SESSION_TOKEN, $token));
		$this->AddParameter(new Parameter(ParameterNames::DATE_MODIFIED, $insertTime->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::USER_SESSION, $serializedSession));
	}
}

class AuthorizationCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::VALIDATE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, strtolower($username)));
	}
}

class AutoAssignPermissionsCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::AUTO_ASSIGN_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class AutoAssignResourcePermissionsCommand extends SqlCommand
{
	public function __construct($resourceId)
	{
		parent::__construct(Queries::AUTO_ASSIGN_RESOURCE_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class CheckEmailCommand extends SqlCommand
{
	public function __construct($emailAddress)
	{
		parent::__construct(Queries::CHECK_EMAIL);
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, strtolower($emailAddress)));
	}
}

class CheckUserExistenceCommand extends SqlCommand
{
	public function __construct($username, $emailAddress)
	{
		parent::__construct(Queries::CHECK_USER_EXISTENCE);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $emailAddress));
	}
}

class CheckUsernameCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::CHECK_USERNAME);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
	}
}

class CookieLoginCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::COOKIE_LOGIN);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class DeleteAccessoryCommand extends SqlCommand
{
	public function __construct($accessoryId)
	{
		parent::__construct(Queries::DELETE_ACCESSORY);
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $accessoryId));
	}
}

class DeleteAttributeCommand extends SqlCommand
{
	public function __construct($attributeId)
	{
		parent::__construct(Queries::DELETE_ATTRIBUTE);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ID, $attributeId));
	}
}

class DeleteAttributeValuesCommand extends SqlCommand
{
	public function __construct($attributeId)
	{
		parent::__construct(Queries::DELETE_ATTRIBUTE_VALUES);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ID, $attributeId));
	}
}

class DeleteAccountActivationCommand extends SqlCommand
{
	public function __construct($activationCode)
	{
		parent::__construct(Queries::DELETE_ACCOUNT_ACTIVATION);
		$this->AddParameter(new Parameter(ParameterNames::ACTIVATION_CODE, $activationCode));
	}
}

class DeleteAnnouncementCommand extends SqlCommand
{
	public function __construct($announcementId)
	{
		parent::__construct(Queries::DELETE_ANNOUNCEMENT);
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_ID, $announcementId));
	}
}

class DeleteBlackoutInstanceCommand extends SqlCommand
{
	public function __construct($instanceId)
	{
		parent::__construct(Queries::DELETE_BLACKOUT_INSTANCE);
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_INSTANCE_ID, $instanceId));
	}
}

class DeleteBlackoutSeriesCommand extends SqlCommand
{
	public function __construct($instanceId)
	{
		parent::__construct(Queries::DELETE_BLACKOUT_SERIES);
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_INSTANCE_ID, $instanceId));
	}
}

class DeleteEmailPreferenceCommand extends SqlCommand
{
	public function __construct($userId, $eventCategory, $eventType)
	{
		parent::__construct(Queries::DELETE_EMAIL_PREFERENCE);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::EVENT_CATEGORY, $eventCategory));
		$this->AddParameter(new Parameter(ParameterNames::EVENT_TYPE, $eventType));
	}
}

class DeleteGroupCommand extends SqlCommand
{
	public function __construct($groupId)
	{
		parent::__construct(Queries::DELETE_GROUP);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
	}
}

class DeleteGroupResourcePermission extends SqlCommand
{
	public function __construct($groupId, $resourceId)
	{
		parent::__construct(Queries::DELETE_GROUP_RESOURCE_PERMISSION);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class DeleteGroupRoleCommand extends SqlCommand
{
	public function __construct($groupId, $roleId)
	{
		parent::__construct(Queries::DELETE_GROUP_ROLE);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::ROLE_ID, $roleId));
	}
}

class DeleteOrphanLayoutsCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::DELETE_ORPHAN_LAYOUTS);
	}
}

class DeleteQuotaCommand extends SqlCommand
{
	public function __construct($quotaId)
	{
		parent::__construct(Queries::DELETE_QUOTA);
		$this->AddParameter(new Parameter(ParameterNames::QUOTA_ID, $quotaId));
	}
}

class DeleteReminderCommand extends SqlCommand
{
	public function __construct($reminder_id)
	{
		parent::__construct(Queries::DELETE_REMINDER);
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_ID, $reminder_id));
	}
}

class DeleteReminderByUserCommand extends SqlCommand
{
	public function __construct($user_id)
	{
		parent::__construct(Queries::DELETE_REMINDER_BY_USER);
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_USER_ID, $user_id));
	}
}

class DeleteReminderByRefNumberCommand extends SqlCommand
{
	public function __construct($refnumber)
	{
		parent::__construct(Queries::DELETE_REMINDER_BY_REFNUMBER);
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_REFNUMBER, $refnumber));
	}
}

class DeleteResourceCommand extends SqlCommand
{
	public function __construct($resourceId)
	{
		parent::__construct(Queries::DELETE_RESOURCE_COMMAND);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class DeleteResourceGroupCommand extends SqlCommand
{
	public function __construct($groupId)
	{
		parent::__construct(Queries::DELETE_RESOURCE_GROUP_COMMAND);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_ID, $groupId));
	}
}

class DeleteResourceReservationsCommand extends SqlCommand
{
	public function __construct($resourceId)
	{
		parent::__construct(Queries::DELETE_RESOURCE_RESERVATIONS_COMMAND);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class DeleteResourceStatusReasonCommand extends SqlCommand
{
	public function __construct($reasonId)
		{
			parent::__construct(Queries::DELETE_RESOURCE_STATUS_REASON_COMMAND);
			$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS_REASON_ID, $reasonId));
		}
}

class DeleteResourceTypeCommand extends SqlCommand
{
	public function __construct($resourceTypeId)
		{
			parent::__construct(Queries::DELETE_RESOURCE_TYPE_COMMAND);
			$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_ID, $resourceTypeId));
		}
}

class DeleteSavedReportCommand extends SqlCommand
{
	public function __construct($reportId, $userId)
	{
		parent::__construct(Queries::DELETE_SAVED_REPORT);
		$this->AddParameter(new Parameter(ParameterNames::REPORT_ID, $reportId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class DeleteScheduleCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::DELETE_SCHEDULE);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class DeleteSeriesCommand extends SqlCommand
{
	public function __construct($seriesId, Date $dateModified)
	{
		parent::__construct(Queries::DELETE_SERIES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::DATE_MODIFIED, $dateModified->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::STATUS_ID, ReservationStatus::Deleted));
	}
}

class DeleteUserCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::DELETE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class DeleteUserGroupCommand extends SqlCommand
{
	public function __construct($userId, $groupId)
	{
		parent::__construct(Queries::DELETE_USER_GROUP);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
	}
}

class DeleteUserResourcePermission extends SqlCommand
{
	public function __construct($userId, $resourceId)
	{
		parent::__construct(Queries::DELETE_USER_RESOURCE_PERMISSION);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class DeleteUserSessionCommand extends SqlCommand
{
	public function __construct($sessionToken)
	{
		parent::__construct(Queries::DELETE_USER_SESSION);
		$this->AddParameter(new Parameter(ParameterNames::SESSION_TOKEN, $sessionToken));
	}
}

class GetAccessoryByIdCommand extends SqlCommand
{
	public function __construct($accessoryId)
	{
		parent::__construct(Queries::GET_ACCESSORY_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $accessoryId));
	}
}

class GetAnnouncementByIdCommand extends SqlCommand
{
	public function __construct($announcementId)
	{
		parent::__construct(Queries::GET_ANNOUNCEMENT_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_ID, $announcementId));
	}
}

class GetAttributesByCategoryCommand extends SqlCommand
{
	public function __construct($attributeCategoryId)
	{
		parent::__construct(Queries::GET_ATTRIBUTES_BY_CATEGORY);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, $attributeCategoryId));
	}
}

class GetAttributeByIdCommand extends SqlCommand
{
	public function __construct($attributeId)
	{
		parent::__construct(Queries::GET_ATTRIBUTE_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ID, $attributeId));
	}
}

class GetAttributeAllValuesCommand extends SqlCommand
{
	public function __construct($attributeCategoryId)
	{
		parent::__construct(Queries::GET_ATTRIBUTE_ALL_VALUES);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, $attributeCategoryId));
	}
}

class GetAttributeMultipleValuesCommand extends SqlCommand
{
	public function __construct($attributeCategoryId, $entityIds)
	{
		parent::__construct(Queries::GET_ATTRIBUTE_MULTIPLE_VALUES);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ENTITY_IDS, $entityIds));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, $attributeCategoryId));
	}
}

class GetAttributeValuesCommand extends SqlCommand
{
	public function __construct($entityId, $attributeCategoryId)
	{
		parent::__construct(Queries::GET_ATTRIBUTE_VALUES);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ENTITY_ID, $entityId));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, $attributeCategoryId));
	}
}

class GetAccessoryListCommand extends SqlCommand
{
	public function __construct(Date $startDate, Date $endDate)
	{
		parent::__construct(Queries::GET_ACCESSORY_LIST);
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
	}
}

class GetAllAccessoriesCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_ACCESSORIES);
	}
}

class GetAllAnnouncementsCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_ANNOUNCEMENTS);
	}
}

class GetAllApplicationAdminsCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_APPLICATION_ADMINS);
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, AccountStatus::ACTIVE));
		$this->AddParameter(new Parameter(ParameterNames::ROLE_LEVEL, RoleLevel::APPLICATION_ADMIN));
	}
}

class GetAllGroupsCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_GROUPS);
	}
}

class GetAllGroupsByRoleCommand extends SqlCommand
{
	/**
	 * @param $roleLevel int|RoleLevel
	 */
	public function __construct($roleLevel)
	{
		parent::__construct(Queries::GET_ALL_GROUPS_BY_ROLE);
		$this->AddParameter(new Parameter(ParameterNames::ROLE_LEVEL, $roleLevel));
	}
}

class GetAllGroupAdminsCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_ALL_GROUP_ADMINS);
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, AccountStatus::ACTIVE));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetAllGroupUsersCommand extends SqlCommand
{
	public function __construct($groupId, $statusId = AccountStatus::ACTIVE)
	{
		parent::__construct(Queries::GET_ALL_GROUP_USERS);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $statusId));
	}
}

class GetAllGroupPermissionsCommand extends SqlCommand
{
	public function __construct($groupId)
	{
		parent::__construct(Queries::GET_GROUP_RESOURCE_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
	}
}


class GetAllGroupRolesCommand extends SqlCommand
{
	public function __construct($groupId)
	{
		parent::__construct(Queries::GET_GROUP_ROLES);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
	}
}

class GetAllQuotasCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_QUOTAS);
	}
}

class GetAllRemindersCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_REMINDERS);
	}
}

class GetAllResourcesCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_RESOURCES);
	}
}

class GetAllResourceGroupsCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_RESOURCE_GROUPS);
	}
}

class GetAllResourceGroupAssignmentsCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_ALL_RESOURCE_GROUP_ASSIGNMENTS);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetAllResourceAdminsCommand extends SqlCommand
{
	public function __construct($resourceId)
	{
		parent::__construct(Queries::GET_ALL_RESOURCE_ADMINS);
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, AccountStatus::ACTIVE));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
		$this->AddParameter(new Parameter(ParameterNames::ROLE_LEVEL, RoleLevel::RESOURCE_ADMIN));
	}
}

class GetAllResourceStatusReasonsCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_RESOURCE_STATUS_REASONS);
	}
}

class GetAllResourceTypesCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_RESOURCE_TYPES);
	}
}

class GetAllSavedReportsForUserCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_ALL_SAVED_REPORTS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetAllSchedulesCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_SCHEDULES);
	}
}

class GetAllUsersByStatusCommand extends SqlCommand
{
	/**
	 * @param int $userStatusId defaults to getting all users regardless of status
	 */
	public function __construct($userStatusId = AccountStatus::ALL)
	{
		parent::__construct(Queries::GET_ALL_USERS_BY_STATUS);
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
	}
}

class GetBlackoutListCommand extends SqlCommand
{
	public function __construct(Date $startDate, Date $endDate, $scheduleId)
	{
		parent::__construct(Queries::GET_BLACKOUT_LIST);
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetBlackoutListFullCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(Queries::GET_BLACKOUT_LIST_FULL);
	}
}

class GetBlackoutInstancesCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_BLACKOUT_INSTANCES);
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_SERIES_ID, $seriesId));
	}
}

class GetBlackoutSeriesByBlackoutIdCommand extends SqlCommand
{
	public function __construct($blackoutId)
	{
		parent::__construct(Queries::GET_BLACKOUT_SERIES_BY_BLACKOUT_ID);
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_INSTANCE_ID, $blackoutId));
	}
}

class GetBlackoutResourcesCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_BLACKOUT_RESOURCES);
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_SERIES_ID, $seriesId));
	}
}

class GetDashboardAnnouncementsCommand extends SqlCommand
{
	public function __construct(Date $currentDate)
	{
		parent::__construct(Queries::GET_DASHBOARD_ANNOUNCEMENTS);
		$this->AddParameter(new Parameter(ParameterNames::CURRENT_DATE, $currentDate->ToDatabase()));
	}
}

class GetGroupByIdCommand extends SqlCommand
{
	public function __construct($groupId)
	{
		parent::__construct(Queries::GET_GROUP_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
	}
}

class GetGroupsIManageCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_GROUPS_I_CAN_MANAGE);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetLayoutCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_SCHEDULE_TIME_BLOCK_GROUPS);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetReminderByUserCommand extends SqlCommand
{
	public function __construct($user_id)
	{
		parent::__construct(Queries::GET_REMINDERS_BY_USER);
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_USER_ID, $user_id));
	}
}

class GetReminderByRefNumberCommand extends SqlCommand
{
	public function __construct($refnumber)
	{
		parent::__construct(Queries::GET_REMINDERS_BY_REFNUMBER);
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_REFNUMBER, $refnumber));
	}
}

class GetReservationForEditingCommand extends SqlCommand
{
	public function __construct($referenceNumber)
	{
		parent::__construct(Queries::GET_RESERVATION_FOR_EDITING);
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_USER_LEVEL_ID, ReservationUserLevel::OWNER));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LEVEL_ID, ResourceLevel::Primary));
	}
}

class GetFullReservationListCommand extends SqlCommand
{
	public function __construct()
	{
		parent::__construct(QueryBuilder::GET_RESERVATION_LIST_FULL());
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_USER_LEVEL_ID, ReservationUserLevel::OWNER));
	}
}

class GetReservationsByAccessoryNameCommand extends SqlCommand
{
	public function __construct(Date $startDate, Date $endDate, $accessoryName)
	{
		parent::__construct(QueryBuilder::GET_RESERVATIONS_BY_ACCESSORY_NAME());
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_NAME, $accessoryName));
	}
}

class GetFullGroupReservationListCommand extends GetFullReservationListCommand
{
	public function __construct($groupIds = array())
	{
		parent::__construct();
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupIds));
	}

	public function GetQuery()
	{
		$query = parent::GetQuery();

		$pos = strripos($query, 'WHERE');
		$newQuery = substr_replace($query, 'INNER JOIN (SELECT user_id FROM user_groups WHERE group_id IN (@groupid)) ss on ss.user_id = owner_id WHERE', $pos, strlen('WHERE'));

//		$newQuery = preg_replace('/WHERE/',
//								 'WHERE owner_id IN (SELECT user_id FROM user_groups WHERE group_id IN (@groupid)) AND ',
//								 $query, 1);

		return $newQuery;
	}
}

class GetReservationListCommand extends SqlCommand
{
	public function __construct(Date $startDate, Date $endDate, $userId, $userLevelId, $scheduleId, $resourceId)
	{
		parent::__construct(QueryBuilder::GET_RESERVATION_LIST());
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_USER_LEVEL_ID, $userLevelId));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class GetReminderNoticesCommand extends SqlCommand
{
	public function __construct(Date $currentDate, $type)
	{
		parent::__construct(Queries::GET_REMINDER_NOTICES);
		$this->AddParameter(new Parameter(ParameterNames::CURRENT_DATE, $currentDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_TYPE, $type));
	}
}

class GetReservationAccessoriesCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_ACCESSORIES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class GetReservationAttachmentCommand extends SqlCommand
{
	public function __construct($fileId)
	{
		parent::__construct(Queries::GET_RESERVATION_ATTACHMENT);
		$this->AddParameter(new Parameter(ParameterNames::FILE_ID, $fileId));
	}
}

class GetReservationAttachmentsCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_ATTACHMENTS_FOR_SERIES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class GetReservationParticipantsCommand extends SqlCommand
{
	public function __construct($instanceId)
	{
		parent::__construct(Queries::GET_RESERVATION_PARTICIPANTS);
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $instanceId));
	}
}

class GetReservationReminders extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_REMINDERS);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class GetReservationResourcesCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_RESOURCES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class GetReservationByIdCommand extends SqlCommand
{
	public function __construct($reservationId)
	{
		parent::__construct(Queries::GET_RESERVATION_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $reservationId));
	}
}

class GetReservationByReferenceNumberCommand extends SqlCommand
{
	public function __construct($referenceNumber)
	{
		parent::__construct(Queries::GET_RESERVATION_BY_REFERENCE_NUMBER);
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
	}
}

class GetReservationSeriesInstances extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_SERIES_INSTANCES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class GetReservationSeriesParticipantsCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_SERIES_PARTICIPANTS);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}


## (C) 2012 Alois Schloegl
class GetResourceByContactInfoCommand extends SqlCommand
{
	public function __construct($contact_info)
	{
		parent::__construct(Queries::GET_RESOURCE_BY_CONTACT_INFO);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_CONTACT, $contact_info));
	}
}

class GetResourceByIdCommand extends SqlCommand
{
	public function __construct($resourceId)
	{
		parent::__construct(Queries::GET_RESOURCE_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class GetResourceByPublicIdCommand extends SqlCommand
{
	public function __construct($publicId)
	{
		parent::__construct(Queries::GET_RESOURCE_BY_PUBLIC_ID);
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
	}
}

class GetResourceGroupCommand extends SqlCommand
{
	public function __construct($groupId)
	{
		parent::__construct(Queries::GET_RESOURCE_GROUP_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_ID, $groupId));
	}
}

class GetResourceTypeCommand extends SqlCommand
{
	public function __construct($resourceTypeId)
		{
			parent::__construct(Queries::GET_RESOURCE_TYPE_BY_ID);
			$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_ID, $resourceTypeId));
		}
}

class GetSavedReportForUserCommand extends SqlCommand
{
	public function __construct($reportId, $userId)
	{
		parent::__construct(Queries::GET_SAVED_REPORT);
		$this->AddParameter(new Parameter(ParameterNames::REPORT_ID, $reportId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetScheduleByIdCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_SCHEDULE_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetScheduleByPublicIdCommand extends SqlCommand
{
	public function __construct($publicId)
	{
		parent::__construct(Queries::GET_SCHEDULE_BY_PUBLIC_ID);
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
	}
}

class GetScheduleResourcesCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_SCHEDULE_RESOURCES);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetUserIdByActivationCodeCommand extends SqlCommand
{
	public function __construct($activationCode)
	{
		parent::__construct(Queries::GET_USERID_BY_ACTIVATION_CODE);
		$this->AddParameter(new Parameter(ParameterNames::ACTIVATION_CODE, $activationCode));
		$this->AddParameter(new Parameter(ParameterNames::STATUS_ID, AccountStatus::AWAITING_ACTIVATION));
	}
}

class GetUserByIdCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetUserByPublicIdCommand extends SqlCommand
{
	public function __construct($publicId)
	{
		parent::__construct(Queries::GET_USER_BY_PUBLIC_ID);
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
	}
}

class GetUserEmailPreferencesCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_EMAIL_PREFERENCES);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetUserGroupsCommand extends SqlCommand
{
	public function __construct($userId, $roleLevels)
	{
		parent::__construct(Queries::GET_USER_GROUPS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::ROLE_LEVEL, $roleLevels));
		$this->AddParameter(new Parameter('@role_null', empty($roleLevels) ? null : '1'));
	}
}

class GetUserRoleCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_ROLES);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}


class GetUserSessionBySessionTokenCommand extends SqlCommand
{
	public function __construct($sessionToken)
	{
		parent::__construct(Queries::GET_USER_SESSION_BY_SESSION_TOKEN);
		$this->AddParameter(new Parameter(ParameterNames::SESSION_TOKEN, $sessionToken));
	}
}

class GetUserSessionByUserIdCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_SESSION_BY_USERID);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class LoginCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::LOGIN_USER);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, strtolower($username)));
	}
}

class MigratePasswordCommand extends SqlCommand
{
	public function __construct($userId, $password, $salt)
	{
		parent::__construct(Queries::MIGRATE_PASSWORD);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
	}
}

class RegisterFormSettingsCommand extends SqlCommand
{
	public function __construct($firstName, $lastName, $username, $email, $password, $organization, $group, $position,
								$address, $phone, $homepage, $timezone)
	{
		parent::__construct(Queries::REGISTER_FORM_SETTINGS);

		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME_SETTING, $firstName));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME_SETTING, $lastName));
		$this->AddParameter(new Parameter(ParameterNames::USERNAME_SETTING, $username));
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS_SETTING, $email));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD_SETTING, $password));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION_SELECTION_SETTING, $organization));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_SETTING, $group));
		$this->AddParameter(new Parameter(ParameterNames::POSITION_SETTING, $position));
		$this->AddParameter(new Parameter(ParameterNames::ADDRESS_SETTING, $address));
		$this->AddParameter(new Parameter(ParameterNames::PHONE_SETTING, $phone));
		$this->AddParameter(new Parameter(ParameterNames::HOMEPAGE_SELECTION_SETTING, $homepage));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_SELECTION_SETTING, $timezone));
	}
}

class RegisterMiniUserCommand extends SqlCommand
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $userStatusId,
								$userRoleId, $language)
	{
		parent::__construct(Queries::REGISTER_MINI_USER);

		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_NAME, $timezone));
		$this->AddParameter(new Parameter(ParameterNames::LANGUAGE, $language));
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ROLE_ID, $userRoleId));
	}
}

class RegisterUserCommand extends SqlCommand
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $language, $homepageId,
								$phone, $organization, $position, $userStatusId, $publicId, $scheduleId)
	{
		parent::__construct(Queries::REGISTER_USER);

		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_NAME, $timezone));
		$this->AddParameter(new Parameter(ParameterNames::LANGUAGE, $language));
		$this->AddParameter(new Parameter(ParameterNames::HOMEPAGE_ID, $homepageId));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phone));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $organization));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
		$this->AddParameter(new Parameter(ParameterNames::DATE_CREATED, Date::Now()
																		->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class RemoveAttributeValueCommand extends SqlCommand
{
	public function __construct($attributeId, $entityId)
	{
		parent::__construct(Queries::REMOVE_ATTRIBUTE_VALUE);

		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ID, $attributeId));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ENTITY_ID, $entityId));
	}
}
class RemoveLegacyPasswordCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::REMOVE_LEGACY_PASSWORD);

		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class RemoveReservationAccessoryCommand extends SqlCommand
{
	public function __construct($seriesId, $accessoryId)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_ACCESSORY);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $accessoryId));

	}
}

class RemoveReservationAttachmentCommand extends SqlCommand
{
	public function __construct($fileId)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_ATTACHMENT);

		$this->AddParameter(new Parameter(ParameterNames::FILE_ID, $fileId));
	}
}

class RemoveReservationCommand extends SqlCommand
{
	public function __construct($referenceNumber)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_INSTANCE);

		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
	}
}

class RemoveReservationReminderCommand extends SqlCommand
{
	public function __construct($seriesId, $reminderType)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_REMINDER);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::REMINDER_TYPE, $reminderType));
	}
}

class RemoveReservationResourceCommand extends SqlCommand
{
	public function __construct($seriesId, $resourceId)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_RESOURCE);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}

class RemoveReservationUserCommand extends SqlCommand
{
	public function __construct($instanceId, $userId)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_USER);

		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $instanceId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class RemoveResourceFromGroupCommand extends SqlCommand
{
	public function __construct($resourceId, $groupId)
	{
		parent::__construct(Queries::REMOVE_RESOURCE_FROM_GROUP);

		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_ID, $groupId));
	}
}

class ReportingCommand extends SqlCommand
{
	public function __construct($fname, $lname, $username, $organization, $group)
	{
		parent::__construct(Queries::GET_REPORT);

		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $organization));
		$this->AddParameter(new Parameter(ParameterNames::GROUP, $group));
	}
}

class GetUserPermissionsCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_RESOURCE_PERMISSIONS);

		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class GetUserPreferenceCommand extends SqlCommand
{
	public function __construct($userId, $name)
	{
		parent::__construct(Queries::GET_USER_PREFERENCE);

		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::NAME, $name));
	}
}

class GetUserPreferencesCommand extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_PREFERENCES);

		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class AddUserPreferenceCommand extends SqlCommand
{
	public function __construct($userId, $name, $value)
	{
		parent::__construct(Queries::ADD_USER_PREFERENCE);

		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::VALUE, $value));
	}
}

class SelectUserGroupPermissions extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_GROUP_RESOURCE_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class SetDefaultScheduleCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::SET_DEFAULT_SCHEDULE);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class UpdateAccessoryCommand extends SqlCommand
{
	public function __construct($accessoryId, $accessoryName, $quantityAvailable)
	{
		parent::__construct(Queries::UPDATE_ACCESSORY);
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_ID, $accessoryId));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_NAME, $accessoryName));
		$this->AddParameter(new Parameter(ParameterNames::ACCESSORY_QUANTITY, $quantityAvailable));
	}
}

class UpdateAnnouncementCommand extends SqlCommand
{
	public function __construct($announcementId, $text, Date $start, Date $end, $priority)
	{
		parent::__construct(Queries::UPDATE_ANNOUNCEMENT);
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_ID, $announcementId));
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_TEXT, $text));
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $start->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $end->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::ANNOUNCEMENT_PRIORITY, $priority));
	}
}

class UpdateAttributeCommand extends SqlCommand
{
	public function __construct($attributeId, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId)
	{
		parent::__construct(Queries::UPDATE_ATTRIBUTE);
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ID, $attributeId));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_LABEL, $label));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_TYPE, (int)$type));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_CATEGORY, (int)$category));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_REGEX, $regex));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_REQUIRED, (int)$required));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_POSSIBLE_VALUES, $possibleValues));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_SORT_ORDER, $sortOrder));
		$this->AddParameter(new Parameter(ParameterNames::ATTRIBUTE_ENTITY_ID, $entityId));
	}
}

class UpdateBlackoutInstanceCommand extends SqlCommand
{
	public function __construct($instanceId, $seriesId, Date $start, Date $end)
	{
		parent::__construct(Queries::UPDATE_BLACKOUT_INSTANCE);
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_INSTANCE_ID, $instanceId));
		$this->AddParameter(new Parameter(ParameterNames::BLACKOUT_SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $start->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $end->ToDatabase()));
	}
}

class UpdateGroupCommand extends SqlCommand
{
	public function __construct($groupId, $groupName, $adminGroupId)
	{
		parent::__construct(Queries::UPDATE_GROUP);
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_NAME, $groupName));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ADMIN_ID, $adminGroupId));
	}
}

class UpdateLoginDataCommand extends SqlCommand
{
	public function __construct($userId, $lastLoginTime, $language)
	{
		parent::__construct(Queries::UPDATE_LOGINDATA);
		$this->AddParameter(new Parameter(ParameterNames::LAST_LOGIN, $lastLoginTime));
		$this->AddParameter(new Parameter(ParameterNames::LANGUAGE, $language));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
	}
}

class UpdateFutureReservationsCommand extends SqlCommand
{
	public function __construct($referenceNumber, $newSeriesId, $currentSeriesId)
	{
		parent::__construct(Queries::UPDATE_FUTURE_RESERVATION_INSTANCES);

		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $currentSeriesId));
		$this->AddParameter(new Parameter(ParameterNames::CURRENT_SERIES_ID, $currentSeriesId));
	}
}

class UpdateReservationCommand extends SqlCommand
{
	public function __construct($referenceNumber,
								$seriesId,
								Date $startDate,
								Date $endDate)
	{
		parent::__construct(Queries::UPDATE_RESERVATION_INSTANCE);

		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
	}
}

class UpdateReservationSeriesCommand extends SqlCommand
{
	public function __construct($seriesId,
								$title,
								$description,
								$repeatType,
								$repeatOptions,
								Date $dateModified,
								$statusId,
								$ownerId
	)
	{
		parent::__construct(Queries::UPDATE_RESERVATION_SERIES);

		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::TITLE, $title));
		$this->AddParameter(new Parameter(ParameterNames::DESCRIPTION, $description));
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_TYPE, $repeatType));
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_OPTIONS, $repeatOptions));
		$this->AddParameter(new Parameter(ParameterNames::DATE_MODIFIED, $dateModified->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::STATUS_ID, $statusId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $ownerId));
	}
}

class UpdateResourceCommand extends SqlCommand
{
	public function __construct($id,
								$name,
								$location,
								$contact,
								$notes,
								TimeInterval $minDuration,
								TimeInterval $maxDuration,
								$autoAssign,
								$requiresApproval,
								$allowMultiday,
								$maxParticipants,
								TimeInterval $minNoticeTime,
								TimeInterval $maxNoticeTime,
								$description,
								$imageName,
								$scheduleId,
								$adminGroupId,
								$allowCalendarSubscription,
								$publicId,
								$sortOrder,
								$resourceTypeId,
								$statusId,
								$reasonId,
								TimeInterval $bufferTime)
	{
		parent::__construct(Queries::UPDATE_RESOURCE);

		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $id));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LOCATION, $location));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_CONTACT, $contact));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_DESCRIPTION, $description));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NOTES, $notes));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MINDURATION, $minDuration->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAXDURATION, $maxDuration->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_AUTOASSIGN, $autoAssign));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_REQUIRES_APPROVAL, $requiresApproval));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ALLOW_MULTIDAY, $allowMultiday));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAX_PARTICIPANTS, $maxParticipants));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MINNOTICE, $minNoticeTime->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAXNOTICE, $maxNoticeTime->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_IMAGE_NAME, $imageName));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ADMIN_ID, $adminGroupId));
		$this->AddParameter(new Parameter(ParameterNames::ALLOW_CALENDAR_SUBSCRIPTION, (int)$allowCalendarSubscription));
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_SORT_ORDER, $sortOrder));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_ID, empty($resourceTypeId) ? null : $resourceTypeId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS, $statusId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS_REASON_ID, $reasonId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_BUFFER_TIME, $bufferTime->ToDatabase()));

	}
}

class UpdateResourceGroupCommand extends SqlCommand
{
	public function __construct($groupId, $name, $parentId)
	{
		parent::__construct(Queries::UPDATE_RESOURCE_GROUP);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_ID, $groupId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_GROUP_PARENT_ID, empty($parentId) ? null : $parentId));
	}
}

class UpdateResourceStatusReasonCommand extends SqlCommand
{
	public function __construct($id, $description)
	{
		parent::__construct(Queries::UPDATE_RESOURCE_STATUS_REASON);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS_REASON_ID, $id));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_STATUS_REASON_DESCRIPTION, $description));
	}
}

class UpdateResourceTypeCommand extends SqlCommand
{
	public function __construct($id, $name, $description)
	{
		parent::__construct(Queries::UPDATE_RESOURCE_TYPE);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_ID, $id));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_TYPE_DESCRIPTION, $description));
	}
}

class UpdateScheduleCommand extends SqlCommand
{
	public function __construct($scheduleId,
								$name,
								$isDefault,
								$weekdayStart,
								$daysVisible,
								$subscriptionEnabled,
								$publicId,
								$adminGroupId)
	{
		parent::__construct(Queries::UPDATE_SCHEDULE);

		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ISDEFAULT, (int)$isDefault));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_WEEKDAYSTART, (int)$weekdayStart));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_DAYSVISIBLE, (int)$daysVisible));
		$this->AddParameter(new Parameter(ParameterNames::ALLOW_CALENDAR_SUBSCRIPTION, (int)$subscriptionEnabled));
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_ADMIN_ID, $adminGroupId));
	}
}

class UpdateScheduleLayoutCommand extends SqlCommand
{
	public function __construct($scheduleId, $layoutId)
	{
		parent::__construct(Queries::UPDATE_SCHEDULE_LAYOUT);

		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
		$this->AddParameter(new Parameter(ParameterNames::LAYOUT_ID, $layoutId));
	}
}

class UpdateUserCommand extends SqlCommand
{
	public function __construct(
		$userId,
		$statusId,
		$encryptedPassword,
		$passwordSalt,
		$firstName,
		$lastName,
		$emailAddress,
		$username,
		$homepageId,
		$timezoneName,
		$lastLogin,
		$allowCalendarSubscription,
		$publicId,
		$language,
		$scheduleId)
	{
		parent::__construct(Queries::UPDATE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $statusId));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $encryptedPassword));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $passwordSalt));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $firstName));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lastName));
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $emailAddress));
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
		$this->AddParameter(new Parameter(ParameterNames::HOMEPAGE_ID, $homepageId));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_NAME, $timezoneName));
		$this->AddParameter(new Parameter(ParameterNames::DATE_MODIFIED, Date::Now()
																		 ->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::LAST_LOGIN, $lastLogin));
		$this->AddParameter(new Parameter(ParameterNames::ALLOW_CALENDAR_SUBSCRIPTION, (int)$allowCalendarSubscription));
		$this->AddParameter(new Parameter(ParameterNames::PUBLIC_ID, $publicId));
		$this->AddParameter(new Parameter(ParameterNames::LANGUAGE, $language));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class UpdateUserAttributesCommand extends SqlCommand
{
	public function __construct(
		$userId,
		$phoneNumber,
		$organization,
		$position
	)
	{
		parent::__construct(Queries::UPDATE_USER_ATTRIBUTES);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phoneNumber));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $organization));
	}
}


class UpdateUserFromLdapCommand extends SqlCommand
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $phone, $organization, $position)
	{
		parent::__construct(Queries::UPDATE_USER_BY_USERNAME);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phone));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $organization));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));
	}
}

class UpdateUserPreferenceCommand extends SqlCommand
{
	public function __construct($userId, $name, $value)
	{
		parent::__construct(Queries::UPDATE_USER_PREFERENCE);

		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::NAME, $name));
		$this->AddParameter(new Parameter(ParameterNames::VALUE, $value));
	}
}

class UpdateUserSessionCommand extends SqlCommand
{
	public function __construct($userId, $token, Date $insertTime, $serializedSession)
	{
		parent::__construct(Queries::UPDATE_USER_SESSION);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::SESSION_TOKEN, $token));
		$this->AddParameter(new Parameter(ParameterNames::DATE_MODIFIED, $insertTime->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::USER_SESSION, $serializedSession));
	}
}