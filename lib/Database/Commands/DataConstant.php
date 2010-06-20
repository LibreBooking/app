<?php
class ParameterNames
{
	private function __construct()
	{}
	
	const CURRENT_DATE = '@current_date';
	const DATE_CREATED = '@dateCreated';
	const DESCRIPTION = '@description';
	const END_DATE = '@endDate';
	const EMAIL_ADDRESS = '@email';
	const FIRST_NAME = '@fname';
	const HOMEPAGE_ID = '@homepageid';
	const GROUP = '@group';
	const IS_ACTIVE = '@isactive';
	const LAST_LOGIN = '@lastlogin';
	const LAST_NAME = '@lname';
	const ORGANIZATION = '@organization';
	const PASSWORD = '@password';
	const PHONE = '@phone';
	const POSITION = '@position';

	const RESERVATION_ID = '@reservationid';
	const RESERVATION_USER_LEVEL_ID = '@levelid';
	
	const RESOURCE_ID = '@resourceid';
	const RESOURCE_ALLOW_MULTIDAY = '@allow_multiday_reservations';
	const RESOURCE_AUTOASSIGN = '@autoassign';
	const RESOURCE_CONTACT = '@contact_info';
	const RESOURCE_COST = '@unit_cost';
	const RESOURCE_DESCRIPTION = '@description';
	const RESOURCE_LOCATION = '@location';
	const RESOURCE_MAX_PARTICIPANTS = '@max_participants';
	const RESOURCE_MAXDURATION = '@max_duration';
	const RESOURCE_MAXNOTICE = '@max_notice_time';
	const RESOURCE_MINDURATION = '@min_duration';
	const RESOURCE_MININCREMENT = '@min_increment';
	const RESOURCE_MINNOTICE = '@min_notice_time';
	const RESOURCE_NAME = '@resource_name';	
	const RESOURCE_NOTES = '@resource_notes';
	const RESOURCE_REQUIRES_APPROVAL = '@requires_approval';
	
	
	const SALT = '@salt';
	const SCHEDULE_ID = '@scheduleid';
	const START_DATE = '@startDate';
	const TIMEZONE_NAME = '@timezone';
	const TITLE = '@title';
	const USER_ID = '@userid';
	const USER_ROLE_ID = '@user_roleid';
	const USER_STATUS_ID = '@user_statusid';
	const USERNAME = '@username';	
	const FIRST_NAME_SETTING = '@fname_setting';
	const LAST_NAME_SETTING = '@lname_setting';
	const USERNAME_SETTING = '@username_setting';	
	const EMAIL_ADDRESS_SETTING = '@email_setting';
	const PASSWORD_SETTING = '@password_setting';
	const ORGANIZATION_SELECTION_SETTING = '@organization_setting';
	const GROUP_SETTING = '@group_setting';
	const POSITION_SETTING = '@position_setting';
	const ADDRESS_SETTING = '@address_setting';
	const PHONE_SETTING = '@phone_setting';
	const HOMEPAGE_SELECTION_SETTING = '@homepage_setting';
	const TIMEZONE_SELECTION_SETTING = '@timezone_setting';	
}

class Queries
{
	private function __construct()
	{}
	
	const ADD_RESERVATION = 
		'INSERT INTO 
			reservations (start_date, end_date, date_created, title, description)
		VALUES (@startDate, @endDate, @dateCreated, @title, @description)';
	
	const ADD_RESERVATION_RESOURCE =
		'INSERT INTO
			reservation_resources (reservation_id, resource_id)
		VALUES (@reservationid, $resourceid)';	
	
	const ADD_RESERVATION_USER  = 
		'INSERT INTO
			reservation_users (reservation_id, user_id, level_id)
		VALUES (@reservationid, @userid, @levelid)';
	
	const AUTO_ASSIGN_PERMISSIONS = 
		'INSERT INTO 
			user_resource_permissions (user_id, resource_id) 
		SELECT 
			@userid as user_id, resourceid as resource_id 
		FROM 
			resources
		WHERE 
			autoassign=1';
	
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
		WHERE (username = @username OR email = @email)';
		
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
		ORDER BY priority DESC';

	const GET_SCHEDULE_TIME_BLOCK_GROUPS = 
		'SELECT 
			tb.label, tb.start_time, tb.end_time, tb.availability_code
		FROM 
			time_blocks tb, time_block_groups tbg, schedule_time_block_groups stbg
		WHERE 
			tbg.block_groupid = stbg.block_group_id AND 
			tb.block_group_id = tbg.block_groupid AND
			stbg.schedule_id = @scheduleid 
		ORDER BY tb.start_time';
	
	// TODO: Pass in "Deleted" status ID
	const GET_RESERVATIONS_COMMAND =
	 'SELECT
		  r.reservationid,
		  r.start_date,
		  r.end_date,
		  r.type_id,
		  r.status_id,
		  r.description,
		  rs.resource_id,
		  u.userid,
		  u.fname,
		  u.lname
		FROM 
			reservations r, users u, resource_schedules rs, schedules s, reservation_resources rr
		WHERE 
			r.user_id = u.userid AND rr.resource_id = rs.resource_id AND 
			rs.schedule_id = @scheduleid AND
			(
		  		(r.start_date BETWEEN @startDate AND @endDate)
		  		OR
		  		(r.end_date BETWEEN @startDate AND @endDate)
		  		OR
		  		(r.start_date <= @startDate AND r.end_date >= @endDate)
			)
			AND r.status_id <> 2';
	 
	const GET_SCHEDULE_RESOURCES = 
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
			group_resource_permissions grp, resources r, user_groups ug
		WHERE
			ug.user_id = @userid AND ug.group_id = grp.group_id AND grp.resource_id = r.resourceid';
	
	const GET_USER_ROLES = 
		'SELECT 
			user_id, user_level 
		FROM 
			roles r, user_roles ur
		WHERE 
			ur.user_id = @userid AND r.roleid = ur.role_id';
	
	const MIGRATE_PASSWORD = 
		'UPDATE 
			users 
		SET 
			password = @password, legacypassword = null, salt = @salt 
		WHERE 
			userid = @userid';

	const REGISTER_FORM_SETTINGS = 
		'INSERT INTO
			registration_form_settings (fname_setting, lname_setting, username_setting, email_setting, password_setting, 
			organization_setting, group_setting, position_setting, address_setting, phone_setting, homepage_setting, timezone_setting)	
		VALUES
			(@fname_setting, @lname_setting, @username_setting, @email_setting, @password_setting, @organization_setting, 
			 @group_setting, @position_setting, @address_setting, @phone_setting, @homepage_setting, @timezone_setting)
		';

	const REGISTER_MINI_USER = 
		'INSERT INTO 
			users (email, password, fname, lname, username, salt, timezone, status_id, role_id)
		VALUES
			(@email, @password, @fname, @lname, @username, @salt, @timezone, @user_statusid, @user_roleid)
		';

	const REGISTER_USER = 
		'INSERT INTO 
			users (email, password, fname, lname, phone, organization_id, position, username, salt, timezone, homepageid, status_id)
		VALUES
			(@email, @password, @fname, @lname, @phone, @organization, @position, @username, @salt, @timezone, @homepageid, @user_statusid)
		';


	const ADD_RESOURCE = 
		'INSERT INTO 
			resources (name, location, contact_info, description, notes, isactive, min_duration, min_increment, 
					   max_duration, unit_cost, autoassign, requires_approval, allow_multiday_reservations, 
					   max_participants, min_notice_time, max_notice_time)
		VALUES
			(@resource_name, @location, @contact_info, @description, @resource_notes, @isactive, @min_duration, @min_increment, 
			 @max_duration, @unit_cost, @autoassign, @requires_approval, @allow_multiday_reservations,
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
	const USER_ID = 'userid';	
	const USERNAME = 'username';	
	const EMAIL = 'email';
	const FIRST_NAME = 'fname';
	const LAST_NAME = 'lname';	
	const PASSWORD = 'password';
	const OLD_PASSWORD = 'legacypassword';
	const USER_CREATED = 'date_created';
	const USER_MODIFIED = 'last_modified';
	const ROLE_ID = 'role_id';
	const USER_STATUS_ID = 'status_id';
	const HOMEPAGE_ID = 'homepageid';
	const LAST_LOGIN = 'lastlogin';
	const TIMEZONE_NAME = 'timezone';
	const SALT = 'salt';

	// USER_ORGANIZATIONS //
	const ORGANIZATION_ID = 'organization_id';

	// USER_ADDRESSES //
	const ADDRESS_ID = 'address_id';

	// USER_LONG_QUOTAS //
	const USER_LQUOTA_ID = 'long_quota_id';

	// USER_DAY_QUOTAS //
	const USER_DQUOTA_ID = 'day_quota_id';
	
	// ROLES //
	const USER_LEVEL = 'user_level';
	
	// ANNOUNCEMENTS //
	const ANNOUNCEMENT_TEXT = 'announcement_text';
	
	// GROUPS //
	const GROUP_ID = 'groupid';
	
	// TIME BLOCKS //
	const BLOCK_LABEL = 'label';
	const BLOCK_CODE = 'availability_code';

	// TIME BLOCK USES //
	const BLOCK_START = 'start_time';
	const BLOCK_END = 'end_time';	

	// RESERVATION //
	const RESERVATION_ID = 'reservationid';
	const RESERVATION_USER = 'user_id';
	const RESERVATION_GROUP = 'group_id';
	const RESERVATION_START = 'start_date';
	const RESERVATION_END = 'end_date';
	const RESERVATION_CREATED = 'date_created';
	const RESERVATION_MODIFIED = 'last_modified';
	const RESERVATION_TYPE = 'type_id';
	const RESERVATION_TITLE = 'title';
	const RESERVATION_DESCRIPTION = 'description';
	const RESERVATION_COST = 'total_cost';
	const RESERVATION_PARENT_ID = 'parent_id';
	
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
	const RESOURCE_ALLOW_MULTIDAY = 'allow_multiday_reservations';
	const RESOURCE_MAX_PARTICIPANTS = 'max_participants';
	const RESOURCE_MINNOTICE = 'min_notice_time';
	const RESOURCE_MAXNOTICE = 'max_notice_time';
	
	// SCHEDULE //
	const SCHEDULE_ID = 'scheduleid';
	const SCHEDULE_NAME = 'name';
	const SCHEDULE_DEFAULT = 'isdefault';
	const SCHEDULE_WEEKDAY_START = 'weekdaystart';
	const SCHEDULE_DAYS_VISIBLE = 'daysvisible';

}
?>