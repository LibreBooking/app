<?php
class FormKeys
{
	private function __construct()
	{}
	
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
	const RESOURCE_LOCATION = 'location';
	const CONTACT_INFO = 'contactInfo';
	const DESCRIPTION = 'description';
	const RESOURCE_NOTES = 'resoNotes';
	const IS_ACTIVE = 'isactive';
	const MIN_DURATION = 'minDuration';
	const MIN_INCREMENT = 'minIncrement';
	const MAX_DURATION = 'maxDuration';
	const UNIT_COST = 'unitCost';
	const AUTO_ASSIGN = 'autoAssign';
	const REQUIRES_APPROVAL = 'requiresApproval';
	const MULTIDAY_RESERVATIONS = 'multidayReservations';
	const MAX_PARTICIPANTS = 'maxParticipants';
	const MIN_NOTICE = 'minNotice';
	const MAX_NOTICE = 'maxNotice';
	const RESOURCE_CONSTRAINTS = 'resourceConstraintId';
	const RESOURCE_LONG_QUOTA = 'resourceLongQuotaId';
	const RESOURCE_DAY_QUOTA = 'resourceDayQuotaId';
	
	
	public static function Evaluate($formKey)
	{
		return eval("return FormKeys::$formKey;");
	}
}
?>