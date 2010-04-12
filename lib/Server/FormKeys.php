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
	
	
	public static function Evaluate($formKey)
	{
		return eval("return FormKeys::$formKey;");
	}
}
?>