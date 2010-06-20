<?php
class FormKeys
{
	private function __construct()
	{}
	
	const BEGIN_DATE = 'beginDate';
	const BEGIN_PERIOD = 'beginPeriod';
	const END_DATE = 'endDate';
	const END_PERIOD = 'endPeriod';
	const END_REPEAT_DATE = 'endRepeatDate';
	const INVITATION_LIST = 'invitationList';
	const PARTICIPANT_LIST = 'participantList';
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
	const RESERVATION_ID = 'reservationId';
	const RESERVATION_TITLE = 'reservationTitle';
	const RESOURCE_ID = 'resourceId';
	const SUMMARY = 'summary';
	const USER_ID = 'userId';
	
	const DEFAULT_HOMEPAGE = 'defaultHomepage';
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const ORGANIZATION = 'organization';
	const GROUP = 'group';
	const ADDRESS = 'address';
	const LANGUAGE = 'language';
	const LAST_NAME = 'lname';
	const LOGIN = 'login';
	const PASSWORD = 'password';
	const PASSWORD_CONFIRM = 'passwordConfirm';
	const PERSIST_LOGIN = 'persistLogin';
	const PHONE = 'phone';
	const POSITION = 'position';
	const RESUME = 'resume';
	const SCHEDULE_ID = 'scheduleId';
	const TIMEZONE = 'timezone';
	const RESOURCE_NAME = 'resourceName';	
	const LOCATION = 'location';
	const CONTACT_INFO = 'contactInfo';
	const DESCRIPTION = 'description';
	const NOTES = 'notes';
	const IS_ACTIVE = 'isactive';
	const MIN_DURATION = 'minDuration';
	const MIN_INCREMENT = 'minIncrement';
	const MAX_DURATION = 'maxDuration';
	const UNIT_COST = 'unitCost';
	const AUTO_ASSIGN = 'autoAssign';
	const REQUIRES_APPROVAL = 'requiresApproval';
	const ALLOW_MULTIDAY = 'allowMultiday';
	const MAX_PARTICIPANTS = 'maxParticipants';
	const MIN_NOTICE = 'minNotice';
	const MAX_NOTICE = 'maxNotice';
	const USERNAME = 'username';
	const RESOURCE = 'resource';
	const REPORT_START = 'reportStart';
	const REPORT_END = 'reportEnd';
	const ADDITIONAL_RESOURCES = 'additionalResources';
	
	
	public static function Evaluate($formKey)
	{
		$key = strtoupper($formKey);
		return eval("return FormKeys::$key;");
	}
}
?>