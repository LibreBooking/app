<?php
class FormKeys
{
	private function __construct()
	{}

	const ADDITIONAL_RESOURCES = 'additionalResources';
	const ADDRESS = 'address';
	const ALLOW_MULTIDAY = 'allowMultiday';
	const AUTO_ASSIGN = 'autoAssign';

	const BEGIN_DATE = 'beginDate';
	const BEGIN_PERIOD = 'beginPeriod';

	const CONTACT_INFO = 'contactInfo';

	const DEFAULT_HOMEPAGE = 'defaultHomepage';
	const DESCRIPTION = 'reservationDescription';
	const DURATION = 'duration';

	const EMAIL = 'email';
	const END_DATE = 'endDate';
	const END_PERIOD = 'endPeriod';
	const END_REPEAT_DATE = 'endRepeatDate';

	const FIRST_NAME = 'fname';

	const GROUP = 'group';
	const GROUP_NAME = 'group_name';
	const GROUP_ADMIN = 'group_admin';

	const INVITATION_LIST = 'invitationList';
	const IS_ACTIVE = 'isactive';

	const LANGUAGE = 'language';
	const LAST_NAME = 'lname';
	const LIMIT = 'limit';
	const LOCATION = 'location';
	const LOGIN = 'login';

	const MIN_DURATION = 'minDuration';
	const MIN_INCREMENT = 'minIncrement';
	const MAX_DURATION = 'maxDuration';
	const MAX_PARTICIPANTS = 'maxParticipants';
	const MIN_NOTICE = 'minNotice';
	const MAX_NOTICE = 'maxNotice';

	const NOTES = 'notes';

	const ORGANIZATION = 'organization';

	const PARTICIPANT_LIST = 'participantList';
	const PASSWORD = 'password';
	const PASSWORD_CONFIRM = 'passwordConfirm';
	const PERSIST_LOGIN = 'persistLogin';
	const PHONE = 'phone';
	const POSITION = 'position';

	const REFERENCE_NUMBER = 'referenceNumber';
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
	const REQUIRES_APPROVAL = 'requiresApproval';
	const RESERVATION_ACTION = 'reservationAction';
	const RESERVATION_ID = 'reservationId';
	const RESERVATION_TITLE = 'reservationTitle';
	const RESOURCE = 'resource';
	const RESOURCE_CONTACT = 'resourceContact';
	const RESOURCE_DESCRIPTION = 'resourceDescription';
	const RESOURCE_ID = 'resourceId';
	const RESOURCE_IMAGE = 'resourceImage';
	const RESOURCE_LOCATION = 'resourceLocation';
	const RESOURCE_NAME = 'resourceName';
	const RESOURCE_NOTES = 'resourceNotes';
	const RESUME = 'resume';
	const RETURN_URL = 'returnUrl';
	const ROLE_ID = 'roleId';

	const SCHEDULE_ID = 'scheduleId';
	const SCHEDULE_NAME = 'scheduleName';
	const SCHEDULE_WEEKDAY_START = 'scheduleWeekdayStart';
	const SCHEDULE_DAYS_VISIBLE = 'scheduleDaysVisible';
	const SERIES_UPDATE_SCOPE = 'seriesUpdateScope';
	const SLOTS_BLOCKED = 'blockedSlots';
	const SLOTS_RESERVABLE = 'reservableSlots';
	const SUMMARY = 'summary';

	const TIMEZONE = 'timezone';

	const UNIT = 'unit';
	const UNIT_COST = 'unitCost';
	const USER_ID = 'userId';
	const USERNAME = 'username';

	public static function Evaluate($formKey)
	{
		$key = strtoupper($formKey);
		return eval("return FormKeys::$key;");
	}
}
?>