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
	
	const VALIDATE_USER = 'SELECT userpassword, salt FROM login WHERE (logon_name = @username OR email = @username)';
	const LOGIN_USER = 'SELECT * FROM login WHERE (logon_name = @username OR email = @username)';
	const UPDATE_LOGINTIME = 'UPDATE login SET lastlogin = @lastlogin WHERE memberid = @userid';
}

class ColumnNames
{
	private function __construct()
	{}
	
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const IS_ADMIN = 'is_admin';
	const LAST_NAME = 'lname';
	const MATCH_COUNT = 'matchcount';
	const PASSWORD = 'userpassword';
	const TIMEZONE = 'timezone';
	const SALT = 'salt';
	const USER_ID = 'memberid';	
}
?>