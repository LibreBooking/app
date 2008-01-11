<?php
require_once('namespace.php');

class FormKeys
{
	private function __construct()
	{}
	
	const EMAIL = 'email';
	const FIRST_NAME = 'firstName';
	const LANGUAGE = 'language';
	const LAST_NAME = 'lastName';
	const LOGIN = 'login';
	const PASSWORD = 'password';
	const PASSWORD_CONFIRM = 'passwordConfirm';
	const PERSIST_LOGIN = 'persistLogin';
	const PHONE = 'phone';
	const RESUME = 'resume';
	const TIMEZONE = 'timezone';
}

class Actions
{
	private function __construct()
	{}
	
	const LOGIN = 'login';
}
?>