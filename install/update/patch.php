<?php
/**
* 1.2.0 to 1.2.1 database patch for 1.2.0 web-upgrade installations
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-26-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
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
		doUpdate();
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
	$db->setOption('portability', DB_PORTABILITY_ALL);

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
function doUpdate() {
	global $db;
	global $conf;

	$alter_user_groups_add_primarykey = array('ALTER TABLE user_groups ADD PRIMARY KEY (groupid, memberid)', 'Adding primary key');
	$create_usergroups_is_admin_index = array('CREATE INDEX usergroups_is_admin ON user_groups (is_admin)', 'Create index');
	$create_reminders = array('CREATE TABLE reminders (
							  reminderid CHAR(16) NOT NULL PRIMARY KEY,
							  memberid CHAR(16) NOT NULL,
							  resid CHAR(16) NOT NULL,
							  reminder_time BIGINT NOT NULL
							  )', 'Create reminders table');

	$create_reminders_time_index = array('CREATE INDEX reminders_time ON reminders (reminder_time)', 'Create index');
	$create_reminders_memberid_index = array('CREATE INDEX reminders_memberid ON reminders (memberid)', 'Create index');
	$create_reminders_resid_index = array('CREATE INDEX reminders_resid ON reminders (resid)', 'Create index');
	$alter_login_add_timezone = array('ALTER TABLE login ADD COLUMN timezone FLOAT NOT NULL DEFAULT 0', 'Add timezone');
	
	$patch121 = array(
					$alter_user_groups_add_primarykey,
					$create_usergroups_is_admin_index,
					$create_reminders,
					$create_reminders_time_index,
					$create_reminders_memberid_index,
					$create_reminders_resid_index,
					$alter_login_add_timezone
					);
	//!#----------------

	//# Must run for all updates
	$select_db = array(array ("use {$conf['db']['dbName']}", 'Selecting database'));
	$to_run[] = $select_db;
	$to_run[] = $patch121;
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
?>