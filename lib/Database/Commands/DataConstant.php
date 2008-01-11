<?php
class ParameterNames
{
	private function __construct()
	{}
	
	const EMAIL_ADDRESS = "@emailaddress";
	const LAST_LOGIN = '@lastlogin';
	const PASSWORD = '@password';
	const SALT = '@salt';
	const USER_ID = '@userid';
	const USER_NAME = '@username';	
}

class Queries
{
	private function __construct()
	{}
	
	const CHECK_USER_EXISTANCE = 
		'SELECT memberid 
		FROM login
		WHERE logon_name = @username OR email = @emailaddress';
		
	const COOKIE_LOGIN = 
		'SELECT memberid, lastlogin, email 
		FROM login 
		WHERE memberid = @userid';
	
	const LOGIN_USER = 
		'SELECT memberid, email, fname, lname, is_admin, timezonename, lastlogin
		FROM login 
		WHERE (logon_name = @username OR email = @username)';
	
	const MIGRATE_PASSWORD = 
		"UPDATE login 
		SET userpassword = @password, password = '', salt = @salt 
		WHERE memberid = @userid";
	
	const UPDATE_LOGINTIME = 
		'UPDATE login 
		SET lastlogin = @lastlogin 
		WHERE memberid = @userid';
	
	const VALIDATE_USER = 
		'SELECT memberid, userpassword, salt, password
		FROM login 
		WHERE (logon_name = @username OR email = @username)';
	
}

class ColumnNames
{
	private function __construct()
	{}
	
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const IS_ADMIN = 'is_admin';
	const LAST_LOGIN = 'lastlogin';
	const LAST_NAME = 'lname';	
	const MATCH_COUNT = 'matchcount';
	const OLD_PASSWORD = 'password';
	const PASSWORD = 'userpassword';
	const TIMEZONE_NAME = 'timezonename';
	const SALT = 'salt';
	const USER_ID = 'memberid';	
}
?>