<?php
/**
* Setup program for phpScheduleIt
*
* This will allow a user with root database privleges to
* automatically set up the required database and its
* tables.  It will also populate any necessary tables.
*
* It uses PEAR::DB to prepare and execute the queries,
* making them database independent.
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 01-28-07
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';
include_once($basedir . '/lib/DBEngine.class.php');
include_once($basedir. '/lib/Template.class.php');

@session_start();	// Start the session

$failed = false;

$t = new Template('phpScheduleIt ' . translate('Setup'), 1);
$t->printHTMLHeader();
doPrintHeader();

if (checkConfig()) {
	if (isset($_POST['login'])) {
		setVars();
		doLogin();
	}
	else if (isset($_POST['create'])) {
		$db = dbConnect();
		doCreate();
		doFinish();
	}
	else {
		doPrintForm();
	}
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
	  <?php if ($conf['db']['drop_old']) echo '<li>' . translate('Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!') . '</li>';?>
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
			. '@' . $conf['db']['hostSpec'];

    // Make connection to database
    $db = DB::connect($dsn);
	$db->setOption('portability', DB_PORTABILITY_ALL);

    // If there is an error, print to browser, print to logfile and kill app
    if (DB::isError($db)) {
        die ('Error connecting to database: ' . $db->getMessage() );
    }
	else {
		echo '<h4 align="center">' . translate('Successfully connected as') . ' ' . $_SESSION['user'] . "</h4>\n"
			. "<form name=\"create\" id=\"create\" method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">\n"
			. "<input type=\"submit\" name=\"create\" value=\"" . translate('Create tables') . "\" class=\"button\" />\n"
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
* - Requires an external file with sql commands
* @param none
*/
function doCreate() {
	global $db;
	global $conf;

	$announcements = DBEngine::get_table('announcements');
	$login = DBEngine::get_table('login');
	$reservations = DBEngine::get_table('reservations');
	$resources = DBEngine::get_table('resources');
	$permission = DBEngine::get_table('permission');
	$schedule_permission = DBEngine::get_table('schedule_permission');
	$schedules = DBEngine::get_table('schedules');
	$reservation_users = DBEngine::get_table('reservation_users');
	$anonymous_users = DBEngine::get_table('anonymous_users');
	$additional_resources = DBEngine::get_table('additional_resources');
	$reservation_resources = DBEngine::get_table('reservation_resources');
	$mutex = DBEngine::get_table('mutex');
	$groups = DBEngine::get_table('groups');
	$user_groups = DBEngine::get_table('user_groups');
	$reminders = DBEngine::get_table('reminders');

	$sqls = array (
					// Create new database
					array ("create database {$conf['db']['dbName']}", "Creating database"),
					// Select it
					array ("use {$conf['db']['dbName']}", "Selecting database"),
					// Create announcement table

					array( "CREATE TABLE $announcements (
								announcementid CHAR(16) NOT NULL PRIMARY KEY,
								announcement VARCHAR(255) NOT NULL DEFAULT '',
								number SMALLINT NOT NULL DEFAULT '0',
								start_datetime INTEGER,
								end_datetime INTEGER
							)", "Creating announcement table"),
					array ("CREATE INDEX announcements_startdatetime ON $announcements(start_datetime)", 'Creating index'),
					array ("CREATE INDEX announcements_enddatetime ON $announcements(end_datetime)", 'Creating index'),
					// Create login table
					array ("CREATE TABLE $login (
							  memberid CHAR(16) NOT NULL PRIMARY KEY,
							  email VARCHAR(75) NOT NULL,
							  password CHAR(32) NOT NULL,
							  fname VARCHAR(30) NOT NULL,
							  lname VARCHAR(30) NOT NULL,
							  phone VARCHAR(16) NOT NULL,
							  institution VARCHAR(255),
							  position VARCHAR(100),
							  e_add CHAR(1) NOT NULL DEFAULT 'y',
							  e_mod CHAR(1) NOT NULL DEFAULT 'y',
							  e_del CHAR(1) NOT NULL DEFAULT 'y',
							  e_app CHAR(1) NOT NULL DEFAULT 'y',
							  e_html CHAR(1) NOT NULL DEFAULT 'y',
							  logon_name VARCHAR(30),
							  is_admin SMALLINT DEFAULT 0,
							  lang VARCHAR(5),
							  timezone FLOAT NOT NULL DEFAULT 0
							  )", 'Creating login table'),
					// Create login indexes
					array ("CREATE INDEX login_email ON $login (email)", 'Creating index'),
					array ("CREATE INDEX login_password ON $login (password)", 'Creating index'),
					array ("CREATE INDEX login_logonname ON $login (logon_name)", 'Creating index'),
					// Create reservations table
					array ("CREATE TABLE $reservations (
							  resid CHAR(16) NOT NULL PRIMARY KEY,
							  machid CHAR(16) NOT NULL,
							  scheduleid CHAR(16) NOT NULL,
							  start_date INT NOT NULL DEFAULT 0,
							  end_date INT NOT NULL DEFAULT 0,
							  starttime INTEGER NOT NULL,
							  endtime INTEGER NOT NULL,
							  created INTEGER NOT NULL,
							  modified INTEGER,
							  parentid CHAR(16),
							  is_blackout SMALLINT NOT NULL DEFAULT 0,
							  is_pending SMALLINT NOT NULL DEFAULT 0,
							  summary TEXT,
							  allow_participation SMALLINT NOT NULL DEFAULT 0,
							  allow_anon_participation SMALLINT NOT NULL DEFAULT 0
							  )", 'Creating reservations table'),
					// Create reservations indexes
					array ("CREATE INDEX res_machid ON $reservations (machid)", 'Creating index'),
					array ("CREATE INDEX res_scheduleid ON $reservations (scheduleid)", 'Creating index'),
					array ("CREATE INDEX reservations_startdate ON $reservations (start_date)", 'Creating index'),
					array ("CREATE INDEX reservations_enddate ON $reservations (end_date)", 'Creating index'),
					array ("CREATE INDEX res_startTime ON $reservations (starttime)", 'Creating index'),
					array ("CREATE INDEX res_endTime ON $reservations (endtime)", 'Creating index'),
					array ("CREATE INDEX res_created ON $reservations (created)", 'Creating index'),
					array ("CREATE INDEX res_modified ON $reservations (modified)", 'Creating index'),
					array ("CREATE INDEX res_parentid ON $reservations (parentid)", 'Creating index'),
					array ("CREATE INDEX res_isblackout ON $reservations (is_blackout)", 'Creating index'),
					array ("CREATE INDEX reservations_pending ON $reservations (is_pending)", 'Creating index'),
					// Create resources table
					array ("CREATE TABLE $resources (
							  machid CHAR(16) NOT NULL PRIMARY KEY,
							  scheduleid CHAR(16) NOT NULL,
							  name VARCHAR(75) NOT NULL,
							  location VARCHAR(250),
							  rphone VARCHAR(16),
							  notes TEXT,
							  status CHAR(1) NOT NULL DEFAULT 'a',
							  minres INTEGER NOT NULL,
							  maxres INTEGER NOT NULL,
							  autoassign SMALLINT,
							  approval SMALLINT,
							  allow_multi SMALLINT,
							  max_participants INTEGER,
							  min_notice_time INTEGER,
							  max_notice_time INTEGER
							  )", 'Creating resources table'),
					// Create resources indexes
					array ("CREATE INDEX rs_scheduleid ON $resources (scheduleid)", 'Creating index'),
					array ("CREATE INDEX rs_name ON $resources (name)", 'Creating index'),
					array ("CREATE INDEX rs_status ON $resources (status)", 'Creating index'),
					// Create permission table
					array ("CREATE TABLE $permission (
							  memberid CHAR(16) NOT NULL,
							  machid CHAR(16) NOT NULL,
							  PRIMARY KEY(memberid, machid)
							  )", 'Creating permission table'),
					// Create permission indexes
					array ("CREATE INDEX per_memberid ON $permission (memberid)", 'Creating index'),
					array ("CREATE INDEX per_machid ON $permission (machid)", 'Creating index'),
					// Create schedule table
					array ("CREATE TABLE $schedules (
							  scheduleid CHAR(16) NOT NULL PRIMARY KEY,
							  scheduletitle CHAR(75),
							  daystart INTEGER NOT NULL,
							  dayend INTEGER NOT NULL,
							  timespan INTEGER NOT NULL,
							  timeformat INTEGER NOT NULL,
							  weekdaystart INTEGER NOT NULL,
							  viewdays INTEGER NOT NULL,
							  usepermissions SMALLINT,
							  ishidden SMALLINT,
							  showsummary SMALLINT,
							  adminemail VARCHAR(75),
							  isdefault SMALLINT
							  )", 'Creating table schedules'),
					// Create schedule indexes
					array ("CREATE INDEX sh_hidden ON $schedules (ishidden)", 'Creating index'),
					array ("CREATE INDEX sh_perms ON $schedules (usepermissions)", 'Creating index'),
					// Create schedule permission tables
					array ("CREATE TABLE $schedule_permission (
							  scheduleid CHAR(16) NOT NULL,
							  memberid CHAR(16) NOT NULL,
							  PRIMARY KEY(scheduleid, memberid)
							  )", 'Creating table schedule_permission'),
					// Create schedule permission indexes
					array ("CREATE INDEX sp_scheduleid ON $schedule_permission (scheduleid)", 'Creating index'),
					array ("CREATE INDEX sp_memberid ON $schedule_permission (memberid)", 'Creating index'),
					// Create reservation/user association table
					array ("CREATE TABLE $reservation_users (
							  resid CHAR(16) NOT NULL,
							  memberid CHAR(16) NOT NULL,
							  owner SMALLINT,
							  invited SMALLINT,
							  perm_modify SMALLINT,
							  perm_delete SMALLINT,
							  accept_code CHAR(16),
							  PRIMARY KEY(resid, memberid)
							  )", 'Creating table reservation_users'),
					// Create reservation/user association indexes
					array ("CREATE INDEX resusers_resid ON $reservation_users (resid)", 'Creating index'),
					array ("CREATE INDEX resusers_memberid ON $reservation_users (memberid)", 'Creating index'),
					array ("CREATE INDEX resusers_owner ON $reservation_users (owner)", 'Creating index'),
					// Create anonymous user table
					array ("CREATE TABLE $anonymous_users (
							  memberid CHAR(16) NOT NULL PRIMARY KEY,
							  email VARCHAR(75) NOT NULL,
							  fname VARCHAR(30) NOT NULL,
							  lname VARCHAR(30) NOT NULL
							  )", 'Creating table anonymous_users'),
					// Create reservation/user association table
					array ("CREATE TABLE $additional_resources (
							  resourceid CHAR(16) NOT NULL PRIMARY KEY,
							  name VARCHAR(75) NOT NULL,
							  status CHAR(1) NOT NULL DEFAULT 'a',
							  number_available INTEGER NOT NULL DEFAULT -1
							  )", 'Creating table additional_resources'),
					// Create reservation/user association indexes
					array ("CREATE INDEX ar_name ON $additional_resources (name)", 'Creating index'),
					array ("CREATE INDEX ar_status ON $additional_resources (status)", 'Creating index'),
					// Create reservation_resources table
					array ("CREATE TABLE $reservation_resources (
							  resid CHAR(16) NOT NULL,
							  resourceid CHAR(16) NOT NULL,
							  owner SMALLINT,
							  PRIMARY KEY(resid, resourceid)
							  )", 'Creating table reservation_resources'),
					// Create reservation_resources indexes
					array ("CREATE INDEX resresources_resid ON $reservation_resources (resid)", 'Creating index'),
					array ("CREATE INDEX resresources_resourceid ON $reservation_resources (resourceid)", 'Creating index'),
					array ("CREATE INDEX resresources_owner ON $reservation_resources (owner)", 'Creating index'),
					// Create mutex table (circumvents MySQL limitations)
					array ("CREATE TABLE $mutex (
							  i INTEGER NOT NULL PRIMARY KEY
							  )", 'Creating table mutex'),
					// Insert needed values
					array ("INSERT INTO $mutex VALUES (0)", 'Insert values'),
					array ("INSERT INTO $mutex VALUES (1)", 'Insert values'),
					// Create groups table
					array ("CREATE TABLE $groups (
							  groupid CHAR(16) NOT NULL PRIMARY KEY,
							  group_name VARCHAR(50) NOT NULL
							  )", 'Creating table groups'),
					// Create user/group relationship table
					array ("CREATE TABLE $user_groups (
							  groupid CHAR(16) NOT NULL,
							  memberid CHAR(50) NOT NULL,
							  is_admin SMALLINT NOT NULL DEFAULT 0,
							  PRIMARY KEY(groupid, memberid)
							  )", 'Creating table user_groups'),
					// Create user/group relationship indexes
					array ("CREATE INDEX usergroups_groupid ON $user_groups (groupid)", 'Creating index'),
					array ("CREATE INDEX usergroups_memberid ON $user_groups (memberid)", 'Creating index'),
					array ("CREATE INDEX usergroups_is_admin ON $user_groups (is_admin)", 'Creating index'),
					// Create reminders table
					array ("CREATE TABLE $reminders (
							  reminderid CHAR(16) NOT NULL PRIMARY KEY,
							  memberid CHAR(16) NOT NULL,
							  resid CHAR(16) NOT NULL,
							  reminder_time BIGINT NOT NULL
							  )", 'Creating table reminders'),
					// Create reminders indexes
					array ("CREATE INDEX reminders_time ON $reminders (reminder_time)", 'Creating index'),
					array ("CREATE INDEX reminders_memberid ON $reminders (memberid)", 'Creating index'),
					array ("CREATE INDEX reminders_resid ON $reminders (resid)", 'Creating index'),
					// Create database user/permission
					array ("grant select, insert, update, delete
							on {$conf['db']['dbName']}.*
							to {$conf['db']['dbUser']}@localhost identified by '{$conf['db']['dbPass']}'", 'Creating database user')
				);

	if ($conf['db']['drop_old']) {	// Drop any old database with same name
		array_unshift($sqls, array ("drop database if exists {$conf['db']['dbName']}", 'Dropping database'));
	}

	foreach ($sqls as $sql) {
		echo $sql[1] . '...';
		$result = $db->query($sql[0]);
		check_result($result);
	}

	// Create default schedule
	echo 'Creating default schedule...';
	$scheduleid = $dbe->get_new_id();
	$result = $dbe->db->query("INSERT INTO $schedules VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", array($scheduleid,'default',480,1200,30,12,0,7,0,0,1,$conf['app']['adminEmail'],1));
	check_result($result);
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
?>