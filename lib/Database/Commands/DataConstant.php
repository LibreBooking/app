<?php
class ParameterNames
{
	var $USER_NAME = '@username';
	var $PASSWORD = '@password';
}

class Queries
{
	var $VALIDATE_USER = 'SELECT COUNT(*) FROM login WHERE ( logon_name = @username OR email = @username) AND password = @password';
}

class ColumnNames
{
	var $USER_ID = 'memberid';
}
?>