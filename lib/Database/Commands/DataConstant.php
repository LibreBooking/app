<?php
class ParameterNames
{
	private function __construct()
	{}
	
	const CURRENT_DATE = '@current_date';
	const EMAIL_ADDRESS = '@emailaddress';
	const END_DATE = '@endDate';
	const FIRST_NAME = '@fname';
	const HOMEPAGE_ID = '@homepageid';
	const INSTITUTION = '@institution';
	const LAST_LOGIN = '@lastlogin';
	const LAST_NAME = '@lname';
	const PASSWORD = '@password';
	const PHONE = '@phone';
	const POSITION = '@position';
	const SALT = '@salt';
	const SCHEDULE_ID = '@scheduleid';
	const START_DATE = '@startDate';
	const TIMEZONE = '@timezone';
	const USER_ID = '@userid';
	const USER_NAME = '@username';	
}

class Queries
{
	private function __construct()
	{}
	
	const AUTO_ASSIGN_PERMISSIONS = 
		'INSERT INTO resource_permission (resourceid, userid) 
		SELECT resourceid, @userid as userid 
		FROM resource WHERE autoassign=1';
	
	const CHECK_EMAIL = 
		'SELECT userid 
		FROM account
		WHERE email = @emailaddress';
		
	const CHECK_USERNAME = 
		'SELECT userid 
		FROM account
		WHERE username = @username';
		
	const CHECK_USER_EXISTANCE = 
		'SELECT userid 
		FROM account
		WHERE username = @username OR email = @emailaddress';
		
	const COOKIE_LOGIN = 
		'SELECT userid, lastlogin, email 
		FROM account 
		WHERE userid = @userid';
	
	const LOGIN_USER = 
		'SELECT userid, email, fname, lname, timezonename, lastlogin, homepageid
		FROM account 
		WHERE (username = @username OR email = @username)';
	
	const GET_ALL_SCHEDULES = 
		'SELECT * 
		FROM schedule';
		
	const GET_DASHBOARD_ANNOUNCEMENTS =
		'SELECT announcement_text 
		FROM announcement
		WHERE (start_datetime <= @current_date AND end_datetime >= @current_date)
		ORDER BY order_number DESC';

	const GET_RESERVATIONS_COMMAND =
		'SELECT * 
		FROM reservation r
		INNER JOIN reservation_user ru ON r.reservationid = ru.reservationid
		INNER JOIN reservation_resource rr ON r.reservationid = rr.reservationid
		INNER JOIN resource_schedule rs ON rr.resourceid = rs.resourceid
		INNER JOIN resource ON rr.resourceid = resource.resourceid
		INNER JOIN account a ON ru.userid = a.userid
		WHERE
		(
		  (r.start_date BETWEEN @startDate AND @endDate)
		  OR
		  (r.end_date BETWEEN @startDate AND @endDate)
		  OR
		  (r.start_date <= @startDate AND r.end_date => @endDate)
		)
		AND rs.scheduleid = @scheduleid
		AND resource.isactive = 1';
	
	const GET_USER_ROLES = 
		'SELECT userid, isadmin 
		FROM accountrole
		WHERE (userid = @userid)';
	
	const MIGRATE_PASSWORD = 
		"UPDATE account 
		SET userpassword = @password, legacypassword = null, salt = @salt 
		WHERE userid = @userid";
	
	const REGISTER_USER = 
		'INSERT INTO account
		(email, userpassword, fname, lname, phone, institution, positionname, username, salt, timezonename, homepageid)
		VALUES
		(@emailaddress, @password, @fname, @lname, @phone, @institution, @position, @username, @salt, @timezone, @homepageid)
		';
		
	const UPDATE_LOGINTIME = 
		'UPDATE account 
		SET lastlogin = @lastlogin 
		WHERE userid = @userid';
		
	const UPDATE_USER_BY_USERNAME = 
		'UPDATE account SET 
			email = @email,
			userpassword = @password,
			salt = @salt,
			fname = @fname,
			lname = @lname,
			phone = @phone,
			institution = @institution,
			positionname = @position
		WHERE username = @username
		';
	
	const VALIDATE_USER = 
		'SELECT userid, userpassword, salt, legacypassword
		FROM account 
		WHERE (username = @username OR email = @username)';
	

	
}

class ColumnNames
{
	private function __construct()
	{}
	
	// ACCOUNT //
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const HOMEPAGE_ID = 'homepageid';
	const LAST_LOGIN = 'lastlogin';
	const LAST_NAME = 'lname';	
	const MATCH_COUNT = 'matchcount';
	const OLD_PASSWORD = 'legacypassword';
	const PASSWORD = 'userpassword';
	const TIMEZONE_NAME = 'timezonename';
	const SALT = 'salt';
	const USER_ID = 'userid';	
	
	// ACCOUNT_ROLE //
	const IS_ADMIN = 'isadmin';
	
	// ANNOUNCEMENT //
	const ANNOUNCEMENT_TEXT = 'announcement_text';
	
	// SCHEDULE //
	const SCHEDULE_ID = 'scheduleid';
	const SCHEDULE_NAME = 'name';
	const SCHEDULE_DEFAULT = 'isdefault';
	const SCHEDULE_START = 'daystart';
	const SCHEDULE_END = 'dayend';
	const SCHEDULE_WEEKDAY_START = 'weekdaystart';
	const SCHEDULE_ADMIN_ID = 'adminid';
	const SCHEDULE_DAYS_VISIBLE = 'daysvisible';

}
?>