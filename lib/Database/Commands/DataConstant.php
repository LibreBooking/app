<?php
class ParameterNames
{
	private function __construct()
	{}
	
	const USER_NAME = '@username';
	const PASSWORD = '@password';
	const LAST_LOGIN = '@lastlogin';
	const USER_ID = '@userid';
}

class Queries
{
	private function __construct()
	{}
	
	const VALIDATE_USER = 'SELECT COUNT(*) FROM login WHERE (logon_name = @username OR email = @username) AND password = @password';
	const LOGIN_USER = 'SELECT * FROM login WHERE (logon_name = @username OR email = @username)';
	const UPDATE_LOGINTIME = 'UPDATE login SET lastlogin = @lastlogin WHERE memberid = @userid';
}

class ColumnNames
{
	private function __construct()
	{}
	
	const USER_ID = 'memberid';
	const FIRST_NAME = 'fname';
	const LAST_NAME = 'lname';
	const IS_ADMIN = 'is_admin';
	const TIMEZONE = 'timezone';
	const EMAIL = 'email';
}
?>