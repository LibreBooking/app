<?php
class ParameterNames
{
	private function __construct()
	{}
	
	const USER_STATUS_ID = '@user_statusid';
	const USER_ROLE_ID = '@user_roleid';
	const CURRENT_DATE = '@current_date';
	const EMAIL_ADDRESS = '@email';
	const END_DATE = '@endDate';
	const FIRST_NAME = '@fname';
	const HOMEPAGE_ID = '@homepageid';
	const ORGANIZATION = '@organization';
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
	const RESOURCE_NAME = '@resource_name';	
	const RESOURCE_LOCATION = '@location';
	const CONTACT_INFO = '@contact_info';
	const DESCRIPTION = '@description';
	const RESOURCE_NOTES = '@resource_notes';
	const IS_ACTIVE = '@isactive';
	const MIN_DURATION = '@min_duration';
	const MIN_INCREMENT = '@min_increment';
	const MAX_DURATION = '@max_duration';
	const UNIT_COST = '@unit_cost';
	const AUTO_ASSIGN = '@autoassign';
	const REQUIRES_APPROVAL = '@requires_approval';
	const MULTIDAY_RESERVATIONS = '@allow_multiple_day_reservations';
	const MAX_PARTICIPANTS = '@max_participants';
	const MIN_NOTICE = '@min_notice_time';
	const MAX_NOTICE = '@max_notice_time';
	const RESOURCE_CONSTRAINTS = '@resource_constraint_id';
	const RESOURCE_LONG_QUOTA = '@resource_long_quota_id';
	const RESOURCE_DAY_QUOTA = '@resource_day_quota_id';
}

class Queries
{
	private function __construct()
	{}
	
	const AUTO_ASSIGN_PERMISSIONS = 
		'INSERT INTO user_resource_permissions (resource_id, user_id) 
		SELECT resourceid as resource_id, @userid as user_id 
		FROM resources WHERE autoassign=1';
	
	const CHECK_EMAIL = 
		'SELECT userid 
		FROM users
		WHERE email = @email';
		
	const CHECK_USERNAME = 
		'SELECT userid 
		FROM users
		WHERE username = @username';
		
	const CHECK_USER_EXISTANCE = 
		'SELECT userid 
		FROM users
		WHERE username = @username OR email = @email';
		
	const COOKIE_LOGIN = 
		'SELECT userid, lastlogin, email 
		FROM users 
		WHERE userid = @userid';
	
	const LOGIN_USER = 
		'SELECT userid, email, fname, lname, timezone, lastlogin, homepageid
		FROM users 
		WHERE (username = @username OR email = @username)';
	
	const GET_ALL_SCHEDULES = 
		'SELECT * 
		FROM schedules';
	
	const GET_ALL_USERS_BY_STATUS = 
		'SELECT userid, fname, lname
		FROM users
		WHERE status_id = @user_statusid';
		
	const GET_DASHBOARD_ANNOUNCEMENTS =
		'SELECT announcement_text 
		FROM announcements
		WHERE (start_datetime <= @current_date AND end_datetime >= @current_date)
		ORDER BY start_datetime DESC';

	const GET_SCHEDULE_TIME_BLOCKS = 
		'SELECT 
			tb.label, tb.starttime, tb.endtime, tb.availability_code
		FROM 
			time_blocks tb, schedule_time_blocks stb
		WHERE 
			tb.blockid = stb.block_id AND stb.scheduleid = @scheduleid';
	
	const GET_RESERVATIONS_COMMAND =
	 'SELECT
		  r.reservationid,
		  r.start_date,
		  r.end_date,
		  r.type_id,
		  r.status_id,
		  r.description,
		  rr.resourceid,
		  u.userid,
		  u.fname,
		  u.lname
		FROM 
			reservations r, resources rr, users u, resource_schedules rs, schedules s, user_roles ur
		WHERE 
			r.user_id = u.userid AND r.resource_id = rr.resourceid AND u.role_id = ur.roleid AND
			rs.resource_id = rr.resourceid AND rs.schedule_id = @scheduleid AND
			(
		  		(r.start_date BETWEEN @startDate AND @endDate)
		  		OR
		  		(r.end_date BETWEEN @startDate AND @endDate)
		  		OR
		  		(r.start_date <= @startDate AND r.end_date >= @endDate)
			)
			AND r.isactive = 1 AND ur.user-level = 1';
	 
	const GET_RESOURCE_SCHEDULES = 
		'SELECT 
			r.*
		FROM 
			resources r, resource_schedules rs 
		WHERE 
			r.resourceid = rs.resource_id AND rs.schedule_id = @scheduleid AND
			r.isactive = 1';
	
	const GET_USER_RESOURCE_PERMISSIONS = 
		'SELECT 
			urp.user_id, r.resourceid, r.name
		FROM
			user_resource_permissions urp, resources r
		WHERE
			urp.user_id = @userid AND r.resourceid = urp.resource_id';
	
	const GET_GROUP_RESOURCE_PERMISSIONS = 
		'SELECT 
			grp.group_id, r.resourceid, r.name
		FROM
			group_resource_permissions grp, resources r, user_groups ug, users u
		WHERE
			u.userid = @userid AND u.group_id = ug.groupid AND ug.groupid = grp.group_id
			AND grp.resource_id = r.resourceid';
	
	const GET_USER_ROLES = 
		'SELECT 
			userid, user_level 
		FROM 
			user_roles, users
		WHERE 
			users.userid = @userid AND user_roles.roleid = users.role_id';
	
	const MIGRATE_PASSWORD = 
		'UPDATE 
			users 
		SET 
			password = @password, legacypassword = null, salt = @salt 
		WHERE 
			userid = @userid';
	
	const REGISTER_USER = 
		'INSERT INTO 
			users (email, password, fname, lname, phone, organization_id, position, username, salt, timezone, homepageid, status_id)
		VALUES
			(@email, @password, @fname, @lname, @phone, @organization, @position, @username, @salt, @timezone, @homepageid, @user_statusid)
		';

	const REGISTER_MINI_USER = 
		'INSERT INTO 
			users (email, password, fname, lname, username, salt, timezone, status_id, role_id)
		VALUES
			(@email, @password, @fname, @lname, @username, @salt, @timezone, @user_statusid, @user_roleid)
		';

	const EDIT_RESOURCE = 
		'INSERT INTO 
			resources (name, location, contact_info, description, notes, isactive, min_duration, min_increment, 
					   max_duration, unit_cost, autoassign, requires_approval, allow_multiple_day_reservations, 
					   max_participants, min_notice_time, max_notice_time)
		VALUES
			(@resource_name, @location, @contact_info, @description, @resource_notes, @isactive, @min_duration, @min_increment, 
			 @max_duration, @unit_cost, @autoassign, @requires_approval, @allow_multiple_day_reservations,
		     @max_participants, @min_notice_time, @max_notice_time)
		';
	
	const UPDATE_LOGINTIME = 
		'UPDATE 
			users 
		SET 
			lastlogin = @lastlogin 
		WHERE 
			userid = @userid';
		
	const UPDATE_USER_BY_USERNAME = 
		'UPDATE 
			users 
		SET 
			email = @email,
			password = @password,
			salt = @salt,
			fname = @fname,
			lname = @lname,
			phone = @phone,
			organization_id = @organization,
			position = @position
		WHERE 
			username = @username';
	
	const VALIDATE_USER = 
		'SELECT userid, password, salt, legacypassword
		FROM users 
		WHERE (username = @username OR email = @username)';
	

	
}

class ColumnNames
{
	private function __construct()
	{}
	
	// USERS //
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const HOMEPAGE_ID = 'homepageid';
	const LAST_LOGIN = 'lastlogin';
	const LAST_NAME = 'lname';	
	const MATCH_COUNT = 'matchcount';
	const OLD_PASSWORD = 'legacypassword';
	const PASSWORD = 'password';
	const SALT = 'salt';
	const TIMEZONE_NAME = 'timezone';
	const USER_ID = 'userid';	
	
	// ACCOUNT_ROLE //
	const IS_ADMIN = 'isadmin';
	
	// ANNOUNCEMENT //
	const ANNOUNCEMENT_TEXT = 'announcement_text';
	
	// GROUP //
	const GROUP_ID = 'groupid';
	
	// LAYOUT //
	const PERIOD_START = 'starttime';
	const PERIOD_END = 'endtime';
	const PERIOD_LABEL = 'label';
	const PERIOD_TYPE = 'periodtypeid';
	
	// RESERVATION //
	const RESERVATION_ID = 'reservationid';
	const RESERVING_USER = 'reserving_user_id';
	const RESERVED_RESOURCE = 'reserved_resource_id';
	const START_DATE = 'start_date';
	const END_DATE = 'end_date';
	const START_TIME = 'start_time';
	const END_TIME = 'end_time';
	const RESERVATION_TYPE = 'type_id';
	const RESERVATION_TITLE = 'title';
	
	// RESERVATION_USER //
	const RESERVATION_OWNER = 'reservation_owner';
	
	// RESOURCE //
	const RESOURCE_ID = 'resourceid';
	const RESOURCE_NAME = 'name';
	const RESOURCE_LOCATION = 'location';
	const RESOURCE_CONTACT = 'contact_info';
	const RESOURCE_DESCRIPTION = 'description';
	const RESOURCE_NOTES = 'notes';
	const RESOURCE_MINDURATION = 'min_duration';
	const RESOURCE_MININCREMENT = 'min_increment';
	const RESOURCE_MAXDURATION = 'max_duration';
	const RESOURCE_COST = 'unit_cost';
	const RESOURCE_AUTOASSIGN = 'autoassign';
	const RESOURCE_REQUIRES_APPROVAL = 'requires_approval';
	const RESOURCE_ALLOW_MULTIDAY = 'allow_multiple_day_reservations';
	const RESOURCE_MAX_PARTICIPANTS = 'max_participants';
	const RESOURCE_MINNOTICE = 'min_notice_time';
	const RESOURCE_MAXNOTICE = 'max_notice_time';
	
	// SCHEDULE //
	const SCHEDULE_ID = 'scheduleid';
	const SCHEDULE_NAME = 'name';
	const SCHEDULE_DEFAULT = 'isdefault';
	const SCHEDULE_START = 'daystart';
	const SCHEDULE_END = 'dayend';
	const SCHEDULE_WEEKDAY_START = 'weekdaystart';
	const SCHEDULE_ADMIN_ID = 'admin_id';
	const SCHEDULE_DAYS_VISIBLE = 'daysvisible';

}
?>