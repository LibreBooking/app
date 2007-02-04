<?php
class ParameterNames
{
	var $USER_NAME = '@username';
	var $PASSWORD = '@password';
	var $LAST_LOGIN = '@lastlogin';
	var $USER_ID = '@userid';
}

class Queries
{
	var $VALIDATE_USER = 'SELECT COUNT(*) FROM login WHERE (logon_name = @username OR email = @username) AND password = @password';
	var $LOGIN_USER = 'SELECT * FROM login WHERE (logon_name = @username OR email = @username)';
	var $UPDATE_LOGINTIME = 'UPDATE login SET lastlogin = @lastlogin WHERE memberid = @userid';
}

class ColumnNames
{
	var $USER_ID = 'memberid';
	var $FIRST_NAME = 'fname';
	var $LAST_NAME = 'lname';
	var $IS_ADMIN = 'is_admin';
	var $TIMEZONE = 'timezone';
	var $EMAIL = 'email';
}
?>