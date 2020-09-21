<?php

/**
 * Copyright 2011-2020 Nick Korbel
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

class FormKeys
{
    private function __construct()
	{
	}

	const ACCESSORY_LIST = 'accessoryList';
	const ACCESSORY_NAME = 'accessoryName';
	const ACCESSORY_ID = 'ACCESSORY_ID';
	const ACCESSORY_QUANTITY_AVAILABLE = 'accessoryQuantityAvailable';
	const ACCESSORY_RESOURCE = 'accessoryResource';
	const ACCESSORY_MIN_QUANTITY = 'ACCESSORY_MIN_QUANTITY';
	const ACCESSORY_MAX_QUANTITY = 'ACCESSORY_MAX_QUANTITY';
	const ADDITIONAL_RESOURCES = 'additionalResources';
	const ADDRESS = 'address';
	const ALLOW_CALENDAR_SUBSCRIPTIONS = 'ALLOW_CALENDAR_SUBSCRIPTIONS';
	const ALLOW_MULTIDAY = 'allowMultiday';
	const ALLOW_PARTICIPATION = 'ALLOW_PARTICIPATION';
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
	const ATTRIBUTE_IS_ADMIN_ONLY = 'ATTRIBUTE_IS_ADMIN_ONLY';
	const ATTRIBUTE_IS_REQUIRED = 'ATTRIBUTE_IS_REQUIRED';
	const ATTRIBUTE_IS_UNIQUE = 'ATTRIBUTE_IS_UNIQUE';
	const ATTRIBUTE_POSSIBLE_VALUES = 'ATTRIBUTE_POSSIBLE_VALUES';
	const ATTRIBUTE_PREFIX = 'psiattribute';
	const ATTRIBUTE_SORT_ORDER = 'attributeOrder';
	const ATTRIBUTE_ENTITY = 'ATTRIBUTE_ENTITY';
	const ATTRIBUTE_LIMIT_SCOPE = 'ATTRIBUTE_LIMIT_SCOPE';
	const ATTRIBUTE_IS_PRIVATE = 'ATTRIBUTE_IS_PRIVATE';
	const ATTRIBUTE_SECONDARY_CATEGORY = 'ATTRIBUTE_SECONDARY_CATEGORY';
	const ATTRIBUTE_SECONDARY_ENTITY_IDS = 'ATTRIBUTE_SECONDARY_ENTITY_IDS';
	const AUTO_ASSIGN = 'autoAssign';
	const AUTO_ASSIGN_CLEAR = 'AUTO_ASSIGN_CLEAR';
	const AUTO_RELEASE_MINUTES = 'AUTO_RELEASE_MINUTES';
	const AVAILABILITY_RANGE = 'AVAILABILITY_RANGE';
	const AVAILABLE_ALL_YEAR = 'AVAILABLE_ALL_YEAR';
	const AVAILABLE_BEGIN_DATE = 'AVAILABLE_BEGIN_DATE';
	const AVAILABLE_END_DATE = 'AVAILABLE_END_DATE';
	const ALLOW_CONCURRENT_RESERVATIONS = 'ALLOW_CONCURRENT_RESERVATIONS';

	const BEGIN_DATE = 'beginDate';
	const BEGIN_PERIOD = 'beginPeriod';
	const BEGIN_TIME = 'beginTime';
	const BLACKOUT_APPLY_TO_SCHEDULE = 'applyToSchedule';
	const BLACKOUT_INSTANCE_ID = 'BLACKOUT_INSTANCE_ID';
	const BUFFER_TIME = 'BUFFER_TIME';
	const BUFFER_TIME_NONE = 'BUFFER_TIME_NONE';

	const CAPTCHA = 'captcha';
	const CONFLICT_ACTION = 'conflictAction';
	const CONTACT_INFO = 'contactInfo';
	const CREDITS = 'CREDITS';
    const CREDIT_COST = 'CREDIT_COST';
    const CREDIT_CURRENCY = 'CREDIT_CURRENCY';
    const CSS_FILE = 'CSS_FILE';
	const CSRF_TOKEN = 'CSRF_TOKEN';
	const CREDIT_QUANTITY = 'CREDIT_QUANTITY';
	const CURRENT_PASSWORD = 'currentPassword';

	const DAY = 'DAY';
	const DEFAULT_HOMEPAGE = 'defaultHomepage';
	const DESCRIPTION = 'reservationDescription';
	const DURATION = 'duration';
	const DELETE_REASON = 'DELETE_REASON';
	const DISPLAY_PAGE = 'DISPLAY_PAGE';

	const EMAIL = 'email';
	const END_DATE = 'endDate';
	const END_PERIOD = 'endPeriod';
	const END_REMINDER_ENABLED = 'END_REMINDER_ENABLED';
	const END_REMINDER_TIME = 'END_REMINDER_TIME';
	const END_REMINDER_INTERVAL = 'END_REMINDER_INTERVAL';
	const END_REPEAT_DATE = 'endRepeatDate';
	const END_TIME = 'endTime';
	const ENFORCE_ALL_DAY = 'ENFORCE_ALL_DAY';
	const ENFORCE_EVERY_DAY = 'ENFORCE_EVERY_DAY';
	const ENABLE_CHECK_IN = 'ENABLE_CHECK_IN';
	const ENABLE_AUTO_RELEASE = 'ENABLE_AUTO_RELEASE';
	const EMAIL_CONTENTS = 'EMAIL_CONTENTS';
	const EMAIL_TEMPLATE_NAME = 'EMAIL_TEMPLATE_NAME';

	const FIRST_NAME = 'fname';
	const FAVICON_FILE = 'FAVICON_FILE';

	const GROUP = 'group';
	const GROUP_ID = 'group_id';
	const GROUP_NAME = 'group_name';
	const GROUP_ADMIN = 'group_admin';
	const GROUP_IMPORT_FILE = 'GROUP_IMPORT_FILE';
	const GUEST_INVITATION_LIST = 'guestInvitationList';
	const GUEST_PARTICIPATION_LIST = 'guestParticipationList';

    const HOURS = 'HOURS';

	const INSTALL_PASSWORD = 'install_password';
	const INSTALL_DB_USER = 'install_db_user';
	const INSTALL_DB_PASSWORD = 'install_db_password';
	const INVITATION_LIST = 'invitationList';
	const IS_ACTIVE = 'isactive';
    const ICS_IMPORT_FILE = 'ICS_IMPORT_FILE';
    const INCLUDE_DELETED = 'INCLUDE_DELETED';
    const INVITED_EMAILS = 'INVITED_EMAILS';
    const IS_DEFAULT = 'IS_DEFAULT';

	const LANGUAGE = 'language';
	const LAST_NAME = 'lname';
	const LIMIT = 'limit';
	const LOCATION = 'location';
	const LOGIN = 'login';
	const LOGO_FILE = 'LOGO_FILE';
	const LAYOUT_TYPE = 'LAYOUT_TYPE';
	const LAYOUT_PERIOD_ID = 'LAYOUT_PERIOD_ID';

	const MIN_DURATION = 'minDuration';
	const MIN_DURATION_NONE = 'minDurationNone';
	const MIN_INCREMENT = 'minIncrement';
	const MIN_INCREMENT_NONE = 'minIncrementNone';
    const MINUTES = 'MINUTES';
	const MAX_DURATION = 'maxDuration';
	const MAX_DURATION_NONE = 'maxDurationNone';
	const MAX_PARTICIPANTS = 'maxParticipants';
	const MAX_PARTICIPANTS_UNLIMITED = 'maxParticipantsUnlimited';
	const MIN_NOTICE_ADD = 'minNoticeAdd';
	const MIN_NOTICE_UPDATE = 'minNoticeUpdate';
	const MIN_NOTICE_DELETE = 'minNoticeDelete';
	const MIN_NOTICE_NONE_ADD = 'minNoticeNoneAdd';
	const MIN_NOTICE_NONE_UPDATE = 'minNoticeNoneUpdate';
	const MIN_NOTICE_NONE_DELETE = 'minNoticeNoneDelete';
	const MIN_CAPACITY = 'MIN_CAPACITY';
	const MAX_NOTICE = 'maxNotice';
	const MAX_NOTICE_NONE = 'maxNoticeNone';
	const MAXIMUM_CONCURRENT_UNLIMITED = 'MAXIMUM_CONCURRENT_UNLIMITED';
	const MAXIMUM_CONCURRENT_RESERVATIONS = 'MAXIMUM_CONCURRENT_RESERVATIONS';
	const MAXIMUM_RESOURCES_PER_RESERVATION_UNLIMITED = 'MAXIMUM_RESOURCES_PER_RESERVATION_UNLIMITED';
	const MAXIMUM_RESOURCES_PER_RESERVATION = 'MAXIMUM_RESOURCES_PER_RESERVATION';
	const MAX_CONCURRENT_RESERVATIONS = 'MAX_CONCURRENT_RESERVATIONS';

	const NAME = 'name';
	const NOTES = 'notes';

	const ORGANIZATION = 'organization';
	const ORIGINAL_RESOURCE_ID = 'ORIGINAL_RESOURCE_ID';
	const OWNER_TEXT = 'ot';

	const PARENT_ID = 'PARENT_ID';
	const PARTICIPANT_LIST = 'participantList';
	const PARTICIPANT_ID = 'PARTICIPANT_ID';
	const PARTICIPANT_TEXT = 'pt';
	const PASSWORD = 'password';
	const PASSWORD_CONFIRM = 'passwordConfirm';
    const PAYPAL_ENABLED = 'ENABLE_PAYPAL';
	const PAYPAL_CLIENT_ID = 'PAYPAL_CLIENT_ID';
	const PAYPAL_SECRET = 'PAYPAL_SECRET';
	const PAYPAL_ENVIRONMENT = 'PAYPAL_ENVIRONMENT';
	const PAYMENT_RESPONSE_DATA = 'PAYMENT_RESPONSE_DATA';
	const PEAK_ALL_DAY = 'PEAK_ALL_DAY';
	const PEAK_ALL_YEAR = 'PEAK_ALL_YEAR';
	const PEAK_EVERY_DAY = 'PEAK_EVERY_DAY';
	const PEAK_CREDITS = 'PEAK_CREDITS';
	const PEAK_BEGIN_MONTH = 'PEAK_BEGIN_MONTH';
	const PEAK_BEGIN_DAY = 'PEAK_BEGIN_DAY';
	const PEAK_END_MONTH = 'PEAK_END_MONTH';
	const PEAK_END_DAY = 'PEAK_END_DAY';
	const PEAK_BEGIN_TIME = 'PEAK_BEGIN_TIME';
	const PEAK_END_TIME = 'PEAK_END_TIME';
	const PEAK_DELETE = 'PEAK_DELETE';
	const PERSIST_LOGIN = 'persistLogin';
	const PHONE = 'phone';
	const POSITION = 'position';
	const PK = 'pk';
	const PERMISSION_TYPE = 'PERMISSION_TYPE';

	const QUOTA_SCOPE= 'QUOTA_SCOPE';

	const REFERENCE_NUMBER = 'referenceNumber';
	const REFUND_AMOUNT = 'REFUND_AMOUNT';
	const REFUND_TRANSACTION_ID = 'REFUND_TRANSACTION_ID';
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
	const RESERVATION_COLOR_RULE_ID = 'RESERVATION_COLOR_RULE_ID';
	const RESERVATION_FILE = 'reservationFile';
	const RESERVATION_ID = 'reservationId';
	const RESERVATION_TITLE = 'reservationTitle';
	const RESERVATION_RETRY_PREFIX = 'RESERVATION_RETRY_PREFIX';
	const RESERVATION_IMPORT_FILE = 'RESERVATION_IMPORT_FILE';
	const RESOURCE = 'resource';
	const RESOURCE_ADMIN_GROUP_ID = 'resourceAdminGroupId';
	const RESOURCE_CONTACT = 'resourceContact';
	const RESOURCE_DESCRIPTION = 'resourceDescription';
	const RESOURCE_ID = 'resourceId';
	const RESOURCE_IMAGE = 'resourceImage';
	const RESOURCE_IMPORT_FILE = 'resourceImportFile';
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
	const ROLLING = 'ROLLING';
	const REPEAT_CUSTOM_DATES = 'repeatCustomDates';

	const SCHEDULE_ID = 'scheduleId';
	const SCHEDULE_NAME = 'scheduleName';
	const SCHEDULE_WEEKDAY_START = 'scheduleWeekdayStart';
	const SCHEDULE_DAYS_VISIBLE = 'scheduleDaysVisible';
	const SCHEDULE_DEFAULT_STYLE = 'SCHEDULE_DEFAULT_STYLE';
	const SEND_AS_EMAIL = 'SEND_AS_EMAIL';
	const SERIES_UPDATE_SCOPE = 'seriesUpdateScope';
	const START_REMINDER_ENABLED = 'START_REMINDER_ENABLED';
	const START_REMINDER_TIME = 'START_REMINDER_TIME';
	const START_REMINDER_INTERVAL = 'START_REMINDER_INTERVAL';
	const SLOTS_BLOCKED = 'blockedSlots';
	const SLOTS_RESERVABLE = 'reservableSlots';
	const STATUS_ID = 'STATUS_ID';
    const STRIPE_ENABLED = 'ENABLE_STRIPE';
	const STRIPE_PUBLISHABLE_KEY = 'STRIPE_PUBLISHABLE_KEY';
	const STRIPE_SECRET_KEY = 'STRIPE_SECRET_KEY';
	const STRIPE_TOKEN = 'STRIPE_TOKEN';
	const SUBMIT = 'SUBMIT';
	const SUMMARY = 'summary';
	const SCHEDULE_ADMIN_GROUP_ID = 'adminGroupId';
	const SELECTED_COLUMNS = 'SELECTED_COLUMNS';
	const SLACK_COMMAND = 'command';
	const SLACK_TEXT = 'text';
	const SLACK_TOKEN = 'token';
	const SPECIFIC_TIME = 'SPECIFIC_TIME';
	const SPECIFIC_DATES = 'SPECIFIC_DATES';

	const THISWEEK = 'THISWEEK';
	const TIMEZONE = 'timezone';
	const TODAY = 'TODAY';
	const TOMMOROW = 'TOMMOROW';
	const TOS_METHOD = 'TOS_METHOD';
	const TOS_APPLICABILITY = 'TOS_APPLICABILITY';
	const TOS_TEXT = 'TOS_TEXT';
	const TOS_URL = 'TOS_URL';
	const TOS_UPLOAD = 'TOS_UPLOAD';
	const TOS_ACKNOWLEDGEMENT = 'TOS_ACKNOWLEDGEMENT';

	const UNIT = 'unit';
	const UNIT_COST = 'unitCost';
	const USER_ID = 'userId';
	const USERNAME = 'username';
	const USER_IMPORT_FILE = 'USER_IMPORT_FILE';
	const USING_SINGLE_LAYOUT = 'USING_SINGLE_LAYOUT';
	const UPDATE_ON_IMPORT = 'UPDATE_ON_IMPORT';

	const VALUE = 'value';

	public static function Evaluate($formKey)
	{
		$key = strtoupper($formKey);
		return eval("return FormKeys::$key;");
	}
}