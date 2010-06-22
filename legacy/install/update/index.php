<?php
/**
* Update program for phpScheduleIt
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 02-01-07
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

@define('BASE_DIR', dirname(__FILE__) . '/../..');
include_once(BASE_DIR . '/lib/DBEngine.class.php');
include_once(BASE_DIR . '/lib/Template.class.php');

@session_start();	// Start the session

$failed = false;

$t = new Template('phpScheduleIt ' . translate('Setup'), 2);
$t->printHTMLHeader();
doPrintHeader();

if (checkConfig()) {
	if (isset($_POST['login'])) {
		setVars();
		doLogin();
	}
	else if (isset($_POST['update'])) {
		$db = dbConnect();
		$version = determineVersion();
		if (version_compare($version, "1.0.0") == -1) {
			echo '<h5>' . translate('phpScheduleIt Update is only available for versions 1.0.0 or later') . '</h5>';
		}
		else if (version_compare($version, "1.2.0") == 0) {
			echo '<h5>' . translate('phpScheduleIt is already up to date') . '</h5>';
		}
		else {
			doUpdate($version);
		}
		doFinish();
	}
	else
		doPrintForm();
}

$t->printHTMLFooter();


/**
* Prints html header
* @param none
*/
function doPrintHeader() {
	global $conf;
?>
<p align="center">
<?php CmnFns::print_language_pulldown(); ?>
</p>
<h3 align="center">phpScheduleIt v<?php echo $conf['app']['version']?></h3>
<?php
}

/**
* Prints out login form
* @param none
*/
function doPrintForm() {
	global $conf;
?>
<h3 align="center"><?php echo translate('Please log into your database')?></h3>
<form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
  <table width="60%" border="0" cellspacing="3" cellpadding="0" align="center" style="border: solid 1px #333333; background-color: #fafafa;">
    <tr>
      <td><?php echo translate('Enter database root username')?></td>
      <td><input type="text" name="user" class="textbox" /></td>
    </tr>
    <tr>
      <td><?php echo translate('Enter database root password')?></td>
      <td><input type="password" name="password" class="textbox" /></td>
    </tr>
    <tr>
      <td><input type="submit" name="login" value="<?php echo translate('Login to database')?>" class="button" /></td>
    </tr>
  </table>
  <br />
  <table width="80%" align="center" cellpadding="3" cellspacing="0" border="0" style="font-family: Verdana, Arial; font-size: 12px; background-color: #ffffff; border: solid 1px #DDDDDD">
    <tr>
      <td>
	  <ul>
	  <li><?php echo translate('Root user is not required. Any database user who has permission to create tables is acceptable.')?></li>
	  <li><?php echo translate('This will set up all the necessary databases and tables for phpScheduleIt.')?></li>
	  <li><?php echo translate('It also populates any required tables.')?></li>
	  </ul></td>
    </tr>
  </table>
</form>
<?php
}

/**
* Checks to make sure necessary fields are set in the config file
* @param none
* @return whether all necessary fields are set
*/
function checkConfig() {
	global $conf;
	switch ($conf['db']['dbType']) {	// Check database type
		case 'mysql' :;
		case 'pgsql' :;
		case 'ibase' :;
		case 'msql' :;
		case 'mssql' :;
		case 'oci8' :;
		case 'odbc' :;
		case 'sybase' :;
		case 'ifx' :;
		case 'fbsql' :;
			break;
		default :
			echo translate('Not a valid database type in the config.php file.');
			return false;
			//break;
	}

	if (empty($conf['db']['dbUser'])) {		// Check database user
		echo translate('Database user is not set in the config.php file.');
		return false;
	}

	if (empty($conf['db']['dbPass'])) {		// Check database password
		echo translate('Database user password is not set in the config.php file.');
		return false;
	}

	if (empty($conf['db']['dbName'])) {		// Check database name
		echo translate('Database name not set in the config.php file.');
		return false;
	}

	return true;
}

/**
* Verifies that the user entered information and sets up session variables
* @param none
*/
function setVars() {
	$_SESSION['user'] = stripslashes(trim($_POST['user']));
	$_SESSION['password'] = stripslashes(trim($_POST['password']));
}

/**
* Create a connection to the database using user supplied data
* @param none
*/
function doLogin() {
	global $conf;
    // Data Source Name: This is the universal connection string
    // See http://www.pear.php.net/manual/en/package.database.php#package.database.db
    // for more information on DSN
    $dsn = $conf['db']['dbType'] . '://'
			. $_SESSION['user']
			. ':' . $_SESSION['password']
			. '@' . $conf['db']['hostSpec'] . '/' . $conf['db']['dbName'];

    // Make connection to database
    $db = DB::connect($dsn);
	@$db->setOption('portability', DB_PORTABILITY_ALL);

    // If there is an error, print to browser, print to logfile and kill app
    if (DB::isError($db)) {
        die ('Error connecting to database: ' . $db->getMessage() );
    }
	else {
		echo '<h4 align="center">' . translate('Successfully connected as') . ' ' . $_SESSION['user'] . "</h4>\n"
			. "<form name=\"create\" id=\"create\" method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n"
			. "<p align=\"center\"><input type=\"submit\" name=\"update\" value=\"" . translate('Update') . "...\" class=\"button\" /></p>\n"
			. "</form>\n";
	}
}

/**
* Create and return a connection to the database
* Requires that setVars() has been called by the user
* loggin in
* @param none
*/
function dbConnect() {
	global $conf;
    // Data Source Name: This is the universal connection string
    // See http://www.pear.php.net/manual/en/package.database.php#package.database.db
    // for more information on DSN
    $dsn = $conf['db']['dbType'] . '://'
			. $_SESSION['user']
			. ':' . $_SESSION['password']
			. '@' . $conf['db']['hostSpec'];

    // Make persistant connection to database
    $db = DB::connect($dsn);

    // If there is an error, print to browser, print to logfile and kill app
    if (DB::isError($db)) {
        die ('Error connecting to database: ' . $db->getMessage() );
    }

    return $db;
}


/**
* Create the database and the tables in it
* @param string $version current version of phpScheduleIt that we are upgrading from
*/
function doUpdate($version) {
	global $db;
	global $conf;

	$dbe = new DBEngine();
	$announcements = $dbe->get_table('announcements');
	$reservations = $dbe->get_table('reservations');
	$resources = $dbe->get_table('resources');
	$login = $dbe->get_table('login');
	$reservation_users = $dbe->get_table('reservation_users');
	$anonymous_users = $dbe->get_table('anonymous_users');
	$additional_resources = $dbe->get_table('additional_resources');
	$reservation_resources = $dbe->get_table('reservation_resources');
	$mutex = $dbe->get_table('mutex');
	$schedules = $dbe->get_table('schedules');
	$groups = $dbe->get_table('groups');
	$user_groups = $dbe->get_table('user_groups');
	$reminders = $dbe->get_table('reminders');

	//# Since version 1.1.0
	$create_announcements = array("CREATE TABLE $announcements (
									  announcementid CHAR(16) NOT NULL PRIMARY KEY,
									  announcement CHAR(255) NOT NULL DEFAULT '',
									  number SMALLINT NOT NULL DEFAULT 0,
									  start_datetime INT,
  									  end_datetime INT
									  )", 'Creating announcements table');
	$create_announcements_sdt_index = array("create index announcements_startdatetime on $announcements(start_datetime)", 'Create start_datetime index');
	$create_announcements_edt_index = array("create index announcements_enddatetime on $announcements(end_datetime)", 'Create end_datetime index');

	$alter_reservations_add_ispending = array("ALTER TABLE $reservations ADD COLUMN is_pending SMALLINT NOT NULL DEFAULT 0 AFTER is_blackout", 'Add is_pending column');
	$create_reservations_ispending_index = array("CREATE INDEX reservations_ispending ON $reservations (is_pending)", 'Add is_pending index');
	$alter_resources_add_approval = array("ALTER TABLE $resources ADD COLUMN approval SMALLINT", 'Add approval column');
	$alter_login_add_eapp = array("ALTER TABLE $login ADD COLUMN e_app CHAR(1) NOT NULL DEFAULT 'y' AFTER e_del", 'Add e_app column');

	$alter_login_add_logonname = array("ALTER TABLE $login ADD COLUMN logon_name CHAR(30)", 'Add logon_name column');
	$create_login_logonname_index = array("CREATE INDEX login_logonname ON $login (logon_name)", 'Add logon_name index');

	$alter_reservations_add_startdate = array("ALTER TABLE $reservations ADD COLUMN start_date int NOT NULL DEFAULT 0 AFTER date", 'Add start_date column');
	$alter_reservations_add_enddate = array("ALTER TABLE $reservations ADD COLUMN end_date int NOT NULL DEFAULT 0 AFTER start_date", 'Add end_date column');
	$create_reservations_index_startdate = array("CREATE INDEX reservations_startdate ON $reservations (start_date)", 'Add start_date index');
	$create_reservations_index_enddate = array("CREATE INDEX reservations_enddate ON $reservations (end_date)", 'Add end_date index');
	$update_reservations_set_startdate = array("UPDATE $reservations SET start_date = date", 'Set start_date = date');
	$update_reservations_set_enddate = array("UPDATE $reservations SET end_date = date", 'Set end_date = date');
	$alter_reservations_drop_date = array("ALTER TABLE $reservations DROP COLUMN date", 'Drop date column');
	$alter_resources_add_allowmulti = array("ALTER TABLE $resources ADD COLUMN allow_multi SMALLINT", 'Add allow_multi column');

	$create_reservation_users = array("CREATE TABLE $reservation_users (
									  resid CHAR(16) NOT NULL,
									  memberid CHAR(16) NOT NULL,
									  owner smallint,
									  invited smallint,
									  perm_modify smallint,
									  perm_delete smallint,
									  accept_code char(16),
									  primary key(resid, memberid)
									  )", 'Create reservation_users table');
	$create_reservationusers_resid_index = array("create index resusers_resid on $reservation_users (resid)", 'Create resusers_resid index');
	$create_reservationusers_memberid_index = array("create index resusers_memberid on $reservation_users (memberid)", 'Create resusers_memberid index');
	$create_reservationusers_owner_index = array("create index resusers_owner on $reservation_users (owner)", 'Create resusers_owner index');
	$migrate_users = array("insert into $reservation_users select resid, memberid, 1, 0, 0, 0, null from $reservations", 'Migrating users');
	$alter_reservations_drop_memberid = array("alter table $reservations drop column memberid, drop index res_memberid", 'Drop memberid column');

	$alter_login_add_isadmin = array("alter table $login add column is_admin smallint default 0", 'Create is_admin on login');

	// Array of all SQL statements to run to upgrade to version 1.1.0
	$version110 = array(
						$create_announcements,
						$create_announcements_sdt_index,
						$create_announcements_edt_index,
						$alter_reservations_add_ispending,
						$create_reservations_ispending_index,
						$alter_resources_add_approval,
						$alter_login_add_eapp,
						$alter_login_add_logonname,
						$create_login_logonname_index,
						$alter_reservations_add_startdate,
						$alter_reservations_add_enddate,
						$create_reservations_index_startdate,
						$create_reservations_index_enddate,
						$update_reservations_set_startdate,
						$update_reservations_set_enddate,
						$alter_reservations_drop_date,
						$alter_resources_add_allowmulti,
						$create_reservation_users,
						$create_reservationusers_resid_index,
						$create_reservationusers_memberid_index,
						$create_reservationusers_owner_index,
						$migrate_users,
						$alter_reservations_drop_memberid,
						$alter_login_add_isadmin
						);

	//!#----------------

	//# Since version 1.2.0
	$create_resources_max_participants = array("ALTER TABLE $resources ADD COLUMN max_participants INTEGER", 'Create column max_participants');
	$create_reservations_allow_participation = array("ALTER TABLE $reservations ADD COLUMN allow_participation smallint not null default 0", 'Create column allow_participation');
	$create_reservations_allow_anon_participation = array("ALTER TABLE $reservations ADD COLUMN allow_anon_participation smallint not null default 0", 'Create column allow_anon_participation');
	$create_anonymous_users_table = array("CREATE TABLE $anonymous_users (
											  memberid CHAR(16) NOT NULL PRIMARY KEY,
											  email VARCHAR(75) NOT NULL,
											  fname VARCHAR(30) NOT NULL,
											  lname VARCHAR(30) NOT NULL
											  )", 'Create anonymous_users table');

	$create_additional_resources = array("CREATE TABLE $additional_resources (
											  resourceid CHAR(16) NOT NULL PRIMARY KEY,
											  name VARCHAR(75) NOT NULL,
											  status CHAR(1) NOT NULL DEFAULT 'a',
											  number_available INTEGER NOT NULL DEFAULT -1
											  )", 'Create additional_resources table');

	$create_ar_name_index = array("CREATE INDEX ar_name ON $additional_resources (name)", 'Create index');
	$create_ar_status_index = array("CREATE INDEX ar_status ON $additional_resources (status)", 'Create index');

	$create_reservation_resources = array("CREATE TABLE $reservation_resources (
											  resid CHAR(16) NOT NULL,
											  resourceid CHAR(16) NOT NULL,
											  owner SMALLINT,
											  PRIMARY KEY(resid, resourceid)
											  )", 'Create reservation_resources table');

	$create_resresources_resid_index = array("CREATE INDEX resresources_resid ON $reservation_resources (resid)", 'Create index');
	$create_resresources_resourceid_index = array("CREATE INDEX resresources_resourceid ON $reservation_resources (resourceid)", 'Create index');
	$create_resresources_owner_index = array("CREATE INDEX resresources_owner ON $reservation_resources (owner)", 'Create index');

	$create_mutex_table = array("CREATE TABLE $mutex(
								  i INTEGER NOT NULL PRIMARY KEY
								  )", 'Create mutex table');

	$insert_mutex_value0 = array("INSERT INTO $mutex VALUES (0)", 'Insert value');
	$insert_mutex_value1 = array("INSERT INTO $mutex VALUES (1)", 'Insert value');

	$alter_starttime = array("ALTER TABLE $reservations CHANGE startTime starttime INTEGER NOT NULL", 'Alter table');
	$alter_endtime = array("ALTER TABLE $reservations CHANGE endTime endtime INTEGER NOT NULL", 'Alter table');
	$alter_minres = array("ALTER TABLE $resources CHANGE minRes minres INTEGER NOT NULL", 'Alter table');
	$alter_maxres = array("ALTER TABLE $resources CHANGE maxRes maxres INTEGER NOT NULL", 'Alter table');
	$alter_autoassign = array("ALTER TABLE $resources CHANGE autoAssign autoassign SMALLINT", 'Alter table');

	$alter_scheduletitle = array("ALTER TABLE $schedules CHANGE scheduleTitle scheduletitle CHAR(75)", 'Alter table');
	$alter_daystart = array("ALTER TABLE $schedules CHANGE dayStart daystart INTEGER NOT NULL", 'Alter table');
	$alter_dayend = array("ALTER TABLE $schedules CHANGE dayEnd dayend INTEGER NOT NULL", 'Alter table');
	$alter_timespan = array("ALTER TABLE $schedules CHANGE timeSpan timespan INTEGER NOT NULL", 'Alter table');
	$alter_timeformat = array("ALTER TABLE $schedules CHANGE timeFormat timeformat INTEGER NOT NULL", 'Alter table');
	$alter_weekdaystart = array("ALTER TABLE $schedules CHANGE weekDayStart weekdaystart INTEGER NOT NULL", 'Alter table');
	$alter_viewdays = array("ALTER TABLE $schedules CHANGE viewDays viewdays INTEGER NOT NULL", 'Alter table');
	$alter_usepermissions = array("ALTER TABLE $schedules CHANGE usePermissions usepermissions SMALLINT", 'Alter table');
	$alter_ishidden = array("ALTER TABLE $schedules CHANGE isHidden ishidden SMALLINT", 'Alter table');
	$alter_showsummary = array("ALTER TABLE $schedules CHANGE showSummary showsummary SMALLINT", 'Alter table');
	$alter_adminemail = array("ALTER TABLE $schedules CHANGE adminEmail adminemail CHAR(75)", 'Alter table');
	$alter_isdefault = array("ALTER TABLE $schedules CHANGE isDefault isdefault SMALLINT", 'Alter table');

	$create_groups = array("CREATE TABLE $groups (
							  groupid CHAR(16) NOT NULL PRIMARY KEY,
							  group_name VARCHAR(50) NOT NULL
							  )", 'Create groups table');

	$create_user_groups = array("CREATE TABLE $user_groups (
							  groupid CHAR(16) NOT NULL,
							  memberid CHAR(50) NOT NULL,
							  is_admin SMALLINT NOT NULL DEFAULT 0,
							  PRIMARY KEY(groupid, memberid)
							  )", 'Creating table user_groups');
	$create_usergroups_groupid_index = array("CREATE INDEX usergroups_groupid ON $user_groups (groupid)", 'Create index');
	$create_usergroups_memberid_index = array("CREATE INDEX usergroups_memberid ON $user_groups (memberid)", 'Create index');
	$create_usergroups_is_admin_index = array("CREATE INDEX usergroups_is_admin ON $user_groups (is_admin)", 'Create index');

	$create_reminders = array("CREATE TABLE $reminders (
							  reminderid CHAR(16) NOT NULL PRIMARY KEY,
							  memberid CHAR(16) NOT NULL,
							  resid CHAR(16) NOT NULL,
							  reminder_time BIGINT NOT NULL
							  )", 'Create reminders table');

	$create_reminders_time_index = array("CREATE INDEX reminders_time ON $reminders (reminder_time)", 'Create index');
	$create_reminders_memberid_index = array("CREATE INDEX reminders_memberid ON $reminders (memberid)", 'Create index');
	$create_reminders_resid_index = array("CREATE INDEX reminders_resid ON $reminders (resid)", 'Create index');

	$alter_login_add_lang = array("ALTER TABLE $login ADD COLUMN lang VARCHAR(5)", 'Add lang');

	$alter_login_add_timezone = array("ALTER TABLE $login ADD COLUMN timezone FLOAT NOT NULL DEFAULT 0", 'Add timezone');

	$alter_resources_add_minnotice = array("ALTER TABLE $resources ADD COLUMN min_notice_time INTEGER NOT NULL DEFAULT 0", 'Add min_notice_time');
	$alter_resources_add_maxnotice = array("ALTER TABLE $resources ADD COLUMN max_notice_time INTEGER NOT NULL DEFAULT 0", 'Add max_notice_time');
	$update_resources_set_mintime = array("UPDATE $resources r, $schedules s SET min_notice_time = dayoffset * 24 WHERE r.scheduleid = s.scheduleid AND dayoffset IS NOT NULL", 'Set min_notice_time');
	$alter_schedules_drop_dayoffset = array("ALTER TABLE $schedules DROP COLUMN dayoffset", 'Drop dayoffset');


	$version120 = array(
					$create_resources_max_participants,
					$create_reservations_allow_participation,
					$create_reservations_allow_anon_participation,
					$create_anonymous_users_table,
					$create_additional_resources,
					$create_ar_name_index,
					$create_ar_status_index,
					$create_reservation_resources,
					$create_resresources_resid_index,
					$create_resresources_resourceid_index,
					$create_resresources_owner_index,
					$create_mutex_table,
					$insert_mutex_value0,
					$insert_mutex_value1,
					$alter_starttime,
					$alter_endtime,
					$alter_minres,
					$alter_maxres,
					$alter_autoassign,
					$alter_scheduletitle,
					$alter_daystart,
					$alter_dayend,
					$alter_timespan,
					$alter_timeformat,
					$alter_weekdaystart,
					$alter_viewdays,
					$alter_usepermissions,
					$alter_ishidden,
					$alter_showsummary,
					$alter_adminemail,
					$alter_isdefault,
					$create_groups,
					$create_user_groups,
					$create_usergroups_groupid_index,
					$create_usergroups_memberid_index,
					$create_usergroups_is_admin_index,
					$create_reminders,
					$create_reminders_time_index,
					$create_reminders_memberid_index,
					$create_reminders_resid_index,
					$alter_login_add_lang,
					$alter_login_add_timezone,
					$alter_resources_add_minnotice,
					$alter_resources_add_maxnotice,
					$update_resources_set_mintime,
					$alter_schedules_drop_dayoffset
					);
	//!#----------------

	//# Must run for all updates
	$select_db = array(array ("use {$conf['db']['dbName']}", 'Selecting database'));
	$to_run[] = $select_db;
	//#

	if ($version == "1.0.0") {
		$to_run[] = $version110;
		$to_run[] = $version120;
	}
	else if ($version = "1.1.0") {
		$to_run[] = $version120;
	}

	foreach ($to_run as $sqls) {
		foreach ($sqls as $sql) {
			echo $sql[1] . '...';
			$result = $db->query($sql[0]);
			check_result($result);
		}
	}
}

/**
* Examine result and print success or failure message to browswer
* @param PEAR::DB $result pear::db result object
*/
function check_result($result) {
	global $failed;
	if (DB::isError($result)) {
		echo '<span style=\"color: #FF0000; font-weight: bold;\">Failed: </span>' . $result->getMessage() . "</span><br/><br/>\n";
		$failed = true;
	}
	else
		echo "<span style=\"color: #00CD00;\">Success</span><br/><br/>\n";
}

function doFinish() {
	global $failed;
	echo '<h5>';
	if ($failed) {
		echo translate('There were errors during the install.');
	}
	else {
		echo translate('You have successfully finished setting up phpScheduleIt and are ready to begin using it.');
	}
	?>
	<br /><br />
	<?php
echo translate('Thank you for using phpScheduleIt');
	echo '</h5>';
}

function determineVersion() {
	$db = new DBEngine();

	$version = "0.0.0";

	$result = $db->db->query('select * from ' . $db->get_table('reservations'));
	$num = $result->numCols();
	if ($num < 12) {
		$version = "0.0.0";
	}
	else if ($num == 12) {
		$version = "1.0.0";
	}
	else if ($num == 13) {
		$version = "1.1.0";
	}
	else if ($num == 14) {
		$version = "1.2.0";
	}
	return $version;
}
?>