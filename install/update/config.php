<?php
/**
* This file sets all the configuration options
* All configuration options, such as colors,
*  text sizes, email addresses, etc.
*  are set in this file.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 05-04-06
* @package phpScheduleIt
*/
/***************************************
* phpScheduleIt                        *
* Version 1.2.0 beta                   *
* http://phpscheduleit.sourceforge.net *
*                                      *
* Nick Korbel                          *
* lqqkout13@users.sourceforge.net      *
/***************************************/
/**
* Please refer to readme.html and LICENSE for any additional information
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* This program is free software; you can redistribute it and/or modify it
* under the terms of the GNU General Public License as published by the
* Free Software Foundation; either version 2 of the License, or (at your option)
* any later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT
* ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along with
* this program; if not, write to the
* Free Software Foundation, Inc.
* 59 Temple Place
* Suite 330
* Boston, MA
* 02111-1307
* USA
*/

/////////////////////////////
// Define common variables //
/////////////////////////////

/*************************************************/
/*                Instructions                   *
**************************************************
* + This section will allow you to change        *
*  common settings such as the timeformat        *
*  and database settings                         *
*                                                *
* + All words (string values) must               *
*  be enclosed in quotation marks                *
*  Numbers must not                              *
*                                                *
* + Default values are                           *
*  given in square brackets []                   *
/*************************************************/

// The full url to the root directory of phpScheduleIt
// Please do not include the trailing slash
$conf['app']['weburi'] = 'http://localhost/phpScheduleIt';
//$conf['app']['weburi'] = 'http://www.yourwebsite.com/path_to_phpScheduleIt';

// Login email for the administrator [admin@email.com]
// It will be used to allow special admin features
// And as the contact email address for users with questions
$conf['app']['adminEmail'] = 'admin@email.com';

// The default language code.  This must be included in the language list in langs.php
$conf['app']['defaultLanguage'] = 'en_US';

// If you are running PHP in safe mode, set this value to 1.  Otherwise keep the default. [0]
$conf['app']['safeMode'] = 0;

// This will hide all personal data from normal users.  Admins will still see full data. [0]
$conf['app']['privacyMode'] = 0;

// Make this a unique string if you have conflicting sessions, or multiple copies of phpScheduleIt on the same server.  Otherwise leave it be. ['PHPSESSID']
$conf['app']['sessionName'] = 'PHPSESSID';

// View time in 12 or 24 hour format [12]
// Only acceptable values are 12 and 24 (if an invalid number is set, 12 hour time will be used)
$conf['app']['timeFormat'] = 12;

// First day of the week for the small navigational calendars [0]
// Must be a value between 0 - 6 (0 = Sunday 6 = Saturday)
$conf['app']['calFirstDay'] = 0;

// Email address of technical support []
$conf['app']['techEmail'] = '';

// Email addresses of additional people to email []
// Multiple addresses must be seperated by a comma
$conf['app']['ccEmail'] = '';

// Whether to send email notifications of reservation and registration activity to administrator [0]
// can be 0 (for no) or 1 (for yes)
$conf['app']['emailAdmin'] = 1;

// How to send email ['mail']
/* Options are:
    'mail' for PHP default mail
    'smtp' for SMTP
    'sendmail' for sendmail
    'qmail' for qmail MTA
*/
$conf['app']['emailType'] = 'mail';

// SMTP email host address []
// This is only required if emailType is SMTP
$conf['app']['smtpHost'] = '';

// SMTP port [25]
// This is only required if emailType is SMTP
$conf['app']['smtpPort'] = 25;

// Path to sendmail ['/usr/sbin/sendmail']
// This only needs to be set if the emailType is 'sendmail'
$conf['app']['sendmailPath'] = '/usr/sbin/sendmail';

// Path to qmail ['/var/qmail/bin/sendmail']
// This only needs to be set if the emailType is 'qmail'
$conf['app']['qmailPath'] = '/var/qmail/bin/sendmail';

// The default password to use when the admin resets a user's password ['password']
$conf['app']['defaultPassword'] = 'password';

// Title of application ['phpScheduleIt']
// Will be used for page titles and in 'From' field of email responses
$conf['app']['title'] = 'phpScheduleIt';

// If we should use the resource permission system or not [1]
// Without permissions, everyone can use any resource
// Can be 0 (for no) or 1 (for yes)
$conf['app']['use_perms'] = 1;

// If we should show the schedule summaries on the read only schedule [0]
// Can be 0 (for no) and 1 (for yes)
$conf['app']['readOnlySummary'] = 0;

// If we should allow guests to view reservation descriptions by clicking on the reservation [0]
// Can be 0 (for no) and 1 (for yes)
$conf['app']['readOnlyDetails'] = 0;

// If we should log system activity or not [0]
// Can be 0 (for no) and 1 (for yes)
$conf['app']['use_log'] = 0;

// Directory/file for log ['/var/log/phpscheduleitlog.txt']
// Specify as /directory/filename.extension
$conf['app']['logfile'] = '/var/log/phpscheduleitlog.txt';

// If we should let the user choose a logon name instead of using their email address [0]
// Can be 0 (to use email as logon) and 1 (to use logon name as logon)
$conf['app']['useLogonName'] = 0;

// Minimum password length required [6]
$conf['app']['minPasswordLength'] = 6;

// Database type to be used by PEAR [mysql]
/* Options are:
    mysql  -> MySQL
    pgsql  -> PostgreSQL
    ibase  -> InterBase
    msql   -> Mini SQL
    mssql  -> Microsoft SQL Server
    oci8   -> Oracle 7/8/8i
    odbc   -> ODBC (Open Database Connectivity)
    sybase -> SyBase
    ifx    -> Informix
    fbsql  -> FrontBase
*/
$conf['db']['dbType'] = 'mysql';

// Database user who can access the schedule database [schedule_user]
$conf['db']['dbUser'] = 'schedule_user';

// Password for above user to access schedule database [password]
$conf['db']['dbPass'] = 'password';

// Name for database [phpscheduleit]
$conf['db']['dbName'] = 'phpscheduleit';

// Prefix to attach to all table names []
$conf['db']['tbl_prefix'] = '';

// Database host specification (hostname[:port]) [localhost]
$conf['db']['hostSpec'] = 'localhost';

// If we should drop (or overwrite) an existing database with the same name during installation [0]
// Can be 0 (for no) or 1 (for yes)
$conf['db']['drop_old'] = 0;

// Prefix to attach to all program-generated primary keys [sc1]
// This will be used to create unique primary keys when multiple databases are being used
// * 3 characterss or less.  Anything over 3 chars will be cut down
$conf['db']['pk_prefix'] = 'sc1';

// Image to appear at the top of each page ['img/phpScheduleIt.gif']
// Leave this string empty if you are not going to use an image
// Specifiy link as 'directory/filename.gif'
$conf['ui']['logoImage'] = 'img/phpScheduleIt.gif';

// Welcome message show at login page ['Welcome to phpScheduleIt!']
$conf['ui']['welcome'] = 'Welcome to phpScheduleIt!';

/*
Configure this section to customize the color of reserved time blocks
Set 'color' to be the color when the mouse is not over the reseravtion
Set 'hover' to be the color when the mouse is moved over the reservation
Set 'text' to be the color of any text that is written on the reservation span
Please DO NOT put the hash mark (#) before the colors

'my_res' is the colors that will be used for all the upcoming reservations that the current user owns
'other_res' is the colors that will be used for all the upcoming reservations on the schedule that the current user does not own
'my_past_res' is the colors that will be used for all past reservations that the current user owns
'other_past_res' is the colors that will be used for all past reservations that the current user does not own
'blackout' is the colors that will be used for blacked out times (hover is only relative to the admin)
*/
$conf['ui']['my_res']         = array ('color' => '5E7FB1', 'hover' => '799DD3', 'text' => 'FFFFFF');
$conf['ui']['other_res']    = array ('color' => 'D2DDEC', 'hover' => 'AFBED3', 'text' => 'FFFFFF');
$conf['ui']['my_past_res']   = array ('color' => 'A0A1A1', 'hover' => '6F7070', 'text' => 'FFFFFF');
$conf['ui']['other_past_res'] = array ('color' => 'CFCFCF', 'hover' => 'ABABAB', 'text' => 'FFFFFF');
$conf['ui']['pending']        = array ('color' => 'E4DC04', 'hover' => 'F7F386', 'text' => 'FFFFFF');
$conf['ui']['blackout']       = array ('color' => '6F292D', 'hover' => '99353A', 'text' => 'FFFFFF');

// If we should print out the reservation owner's name in the summary box [1]
// Can be 0 (for no) and 1 (for yes)
$conf['app']['prefixNameOnSummary'] = 1;

// Available positions to select when registering
// If you add values to this variable, they will appear in a pull down menu.  If you do not add values
//  then the position field will be a text box instead of a pull down menu
// Comment out (add // before all $conf['ui']['positions'][]) to display a text box instead of a select menu
// Add $conf['ui']['positions'][] values to add positions
$conf['ui']['positions'] = array();            // DO NOT CHANGE THIS LINE
//$conf['ui']['positions'][] = "";

// Available institutions to select when registering
// If you add values to this variable, they will appear in a pull down menu.  If you do not add values
//  then the institution field will be a text box instead of a pull down menu
// Comment out (add // before all $conf['ui']['institutions'][]) to display a text box instead of a select menu
// Add $conf['ui']['institutions'][] values to add institutions
$conf['ui']['institutions'] = array();            // DO NOT CHANGE THIS LINE
//$conf['ui']['institutions'][] = "";

// LDAP Settings
// Should we use LDAP for authentication and enable transparent user registration.
//  User registration data(mail, phone, etc.) is pulled from LDAP.
//  If true the user will have to login with their LDAP uid instead of email address.
$conf['ldap']['authentication'] = false;
$conf['ldap']['host'] = 'ldap.host.com';
$conf['ldap']['port'] = 389;
// LDAP people search base. Set this to where people in your organization are stored in LDAP,
// typically ou=people,o=domain.com.
$conf['ldap']['basedn'] = "ou=people,o=domain.com";

// This will allow or disable user self-registration.  If this is disabled, the admin will only be able to create users [1]
$conf['app']['allowSelfRegistration'] = 1;

// This will allow or disable the generation of RSS feeds for users to view their reservation data [1]
$conf['app']['allowRss'] = 1;

// The GMT hour difference for the server
$conf['app']['timezone'] = 0;

// The amount of minutes before a reservation that a user can get a reminder [array()]
// Add minutes in as integers ie) array(5,10,15,30)
// The reminder email job must be scheduled for emails to be sent (see readme)
$conf['app']['allowed_reminder_times'] = array(5, 10, 30);

// See time block customization above
$conf['ui']['participant_res']		= array ('color' => 'CE56D6', 'hover' => 'E174E8', 'text' => 'FFFFFF');
$conf['ui']['participant_past_res']	= array ('color' => '641293', 'hover' => '7B25AC', 'text' => 'FFFFFF');
?>