<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class FormKeys
{
	private function __construct()
	{
	}

	const ACCESSORY_LIST = 'accessoryList';
	const ACCESSORY_NAME = 'accessoryName';
	const ACCESSORY_ID = 'ACCESSORY_ID';
	const ACCESSORY_QUANTITY_AVAILABLE = 'accessoryQuantityAvailable';
	const ADDITIONAL_RESOURCES = 'additionalResources';
	const ADDRESS = 'address';
	const ALLOW_MULTIDAY = 'allowMultiday';
	const ANNOUNCEMENT_TEXT = 'announcementText';
	const ANNOUNCEMENT_START = 'announcementStart';
	const ANNOUNCEMENT_END = 'announcementEnd';
	const ANNOUNCEMENT_PRIORITY = 'announcementPriority';
	const ATTRIBUTE_ID = 'ATTRIBUTE_ID';
	const ATTRIBUTE_VALUE = 'ATTRIBUTE_VALUE';
	const ATTRIBUTE_LABEL = 'ATTRIBUTE_LABEL';
	const ATTRIBUTE_TYPE = 'ATTRIBUTE_TYPE';
	const ATTRIBUTE_CATEGORY = 'ATTRIBUTE_CATEGORY';
	const ATTRIBUTE_VALIDATION_EXPRESSION = 'ATTRIBUTE_VALIDATION_EXPRESSION';
	const ATTRIBUTE_IS_REQUIRED = 'ATTRIBUTE_IS_REQUIRED';
	const ATTRIBUTE_IS_UNIQUE = 'ATTRIBUTE_IS_UNIQUE';
	const ATTRIBUTE_POSSIBLE_VALUES = 'ATTRIBUTE_POSSIBLE_VALUES';
	const ATTRIBUTE_PREFIX = 'psiattribute';
	const ATTRIBUTE_SORT_ORDER = 'attributeOrder';
	const ATTRIBUTE_ENTITY = 'ATTRIBUTE_ENTITY';
	const AUTO_ASSIGN = 'autoAssign';

	const BEGIN_DATE = 'beginDate';
	const BEGIN_PERIOD = 'beginPeriod';
	const BEGIN_TIME = 'beginTime';
	const BLACKOUT_APPLY_TO_SCHEDULE = 'applyToSchedule';
	const BLACKOUT_INSTANCE_ID = 'BLACKOUT_INSTANCE_ID';
	const BUFFER_TIME = 'BUFFER_TIME';

	const CAPTCHA = 'captcha';
	const CONFLICT_ACTION = 'conflictAction';
	const CONTACT_INFO = 'contactInfo';
	const CSS_FILE = 'CSS_FILE';
	const CURRENT_PASSWORD = 'currentPassword';

	const DEFAULT_HOMEPAGE = 'defaultHomepage';
	const DESCRIPTION = 'reservationDescription';
	const DURATION = 'duration';

	const EMAIL = 'email';
	const END_DATE = 'endDate';
	const END_PERIOD = 'endPeriod';
	const END_REMINDER_ENABLED = 'END_REMINDER_ENABLED';
	const END_REMINDER_TIME = 'END_REMINDER_TIME';
	const END_REMINDER_INTERVAL = 'END_REMINDER_INTERVAL';
	const END_REPEAT_DATE = 'endRepeatDate';
	const END_TIME = 'endTime';

	const FIRST_NAME = 'fname';

	const GROUP = 'group';
	const GROUP_ID = 'group_id';
	const GROUP_NAME = 'group_name';
	const GROUP_ADMIN = 'group_admin';

	const INSTALL_PASSWORD = 'install_password';
	const INSTALL_DB_USER = 'install_db_user';
	const INSTALL_DB_PASSWORD = 'install_db_password';
	const INVITATION_LIST = 'invitationList';
	const IS_ACTIVE = 'isactive';

	const LANGUAGE = 'language';
	const LAST_NAME = 'lname';
	const LIMIT = 'limit';
	const LOCATION = 'location';
	const LOGIN = 'login';
	const LOGO_FILE = 'LOGO_FILE';

	const MIN_DURATION = 'minDuration';
	const MIN_INCREMENT = 'minIncrement';
	const MAX_DURATION = 'maxDuration';
	const MAX_PARTICIPANTS = 'maxParticipants';
	const MIN_NOTICE = 'minNotice';
	const MAX_NOTICE = 'maxNotice';

	const NOTES = 'notes';

	const ORGANIZATION = 'organization';

	const PARENT_ID = 'PARENT_ID';
	const PARTICIPANT_LIST = 'participantList';
	const PASSWORD = 'password';
	const PASSWORD_CONFIRM = 'passwordConfirm';
	const PERSIST_LOGIN = 'persistLogin';
	const PHONE = 'phone';
	const POSITION = 'position';

	const REFERENCE_NUMBER = 'referenceNumber';
	const REMOVED_FILE_IDS = 'removeFile';
	const REPEAT_OPTIONS = 'repeatOptions';
	const REPEAT_EVERY = 'repeatEvery';
	const REPEAT_SUNDAY = 'repeatSunday';
	const REPEAT_MONDAY = 'repeatMonday';
	const REPEAT_TUESDAY = 'repeatTuesday';
	const REPEAT_WEDNESDAY = 'repeatWednesday';
	const REPEAT_THURSDAY = 'repeatThursday';
	const REPEAT_FRIDAY = 'repeatFriday';
	const REPEAT_SATURDAY = 'repeatSaturday';
	const REPEAT_MONTHLY_TYPE = 'repeatMonthlyType';
	const REPORT_START = 'reportStart';
	const REPORT_END = 'reportEnd';
	const REPORT_GROUPBY = 'REPORT_GROUPBY';
	const REPORT_RANGE = 'REPORT_RANGE';
	const REPORT_RESULTS = 'reportResults';
	const REPORT_USAGE = 'REPORT_USAGE';
	const REPORT_NAME = 'REPORT_NAME';
	const REQUIRES_APPROVAL = 'requiresApproval';
	const RESERVATION_ACTION = 'reservationAction';
	const RESERVATION_COLOR = 'RESERVATION_COLOR';
	const RESERVATION_FILE = 'reservationFile';
	const RESERVATION_ID = 'reservationId';
	const RESERVATION_TITLE = 'reservationTitle';
	const RESOURCE = 'resource';
	const RESOURCE_ADMIN_GROUP_ID = 'resourceAdminGroupId';
	const RESOURCE_CONTACT = 'resourceContact';
	const RESOURCE_DESCRIPTION = 'resourceDescription';
	const RESOURCE_ID = 'resourceId';
	const RESOURCE_IMAGE = 'resourceImage';
	const RESOURCE_LOCATION = 'resourceLocation';
	const RESOURCE_NAME = 'resourceName';
	const RESOURCE_NOTES = 'resourceNotes';
	const RESOURCE_SORT_ORDER = 'RESOURCE_SORT_ORDER';
	const RESOURCE_TYPE_ID = 'RESOURCE_TYPE_ID';
	const RESOURCE_TYPE_DESCRIPTION = 'RESOURCE_TYPE_DESCRIPTION';
	const RESOURCE_TYPE_NAME = 'RESOURCE_TYPE_NAME';
	const RESUME = 'resume';
	const RETURN_URL = 'returnUrl';
	const ROLE_ID = 'roleId';
	const RESOURCE_STATUS_ID = 'RESOURCE_STATUS_ID';
	const RESOURCE_STATUS_REASON = 'RESOURCE_STATUS_REASON';
	const RESOURCE_STATUS_REASON_ID = 'RESOURCE_STATUS_REASON_ID';
	const RESOURCE_STATUS_UPDATE_SCOPE = 'RESOURCE_STATUS_UPDATE_SCOPE';

	const SCHEDULE_ID = 'scheduleId';
	const SCHEDULE_NAME = 'scheduleName';
	const SCHEDULE_WEEKDAY_START = 'scheduleWeekdayStart';
	const SCHEDULE_DAYS_VISIBLE = 'scheduleDaysVisible';
	const SERIES_UPDATE_SCOPE = 'seriesUpdateScope';
	const START_REMINDER_ENABLED = 'START_REMINDER_ENABLED';
	const START_REMINDER_TIME = 'START_REMINDER_TIME';
	const START_REMINDER_INTERVAL = 'START_REMINDER_INTERVAL';
	const SLOTS_BLOCKED = 'blockedSlots';
	const SLOTS_RESERVABLE = 'reservableSlots';
	const STATUS_ID = 'STATUS_ID';
	const SUBMIT = 'SUBMIT';
	const SUMMARY = 'summary';
	const SCHEDULE_ADMIN_GROUP_ID = 'adminGroupId';

	const TIMEZONE = 'timezone';

	const UNIT = 'unit';
	const UNIT_COST = 'unitCost';
	const USER_ID = 'userId';
	const USERNAME = 'username';
	const USING_SINGLE_LAYOUT = 'USING_SINGLE_LAYOUT';

	public static function Evaluate($formKey)
	{
		$key = strtoupper($formKey);
		return eval("return FormKeys::$key;");
	}
}

?>