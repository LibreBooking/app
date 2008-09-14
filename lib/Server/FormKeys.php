<?php
class FormKeys
{
	private function __construct()
	{}
	
	const DEFAULT_HOMEPAGE = 'defaultHomepage';
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const INSTITUTION = 'institution';
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
	
	public static function Evaluate($formKey)
	{
		return eval("return FormKeys::$formKey;");
	}
}
?>