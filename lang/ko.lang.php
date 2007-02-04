<?php
/**
* Korean (ko) translation file
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Kim Taegon <gony@mygony.com>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all of the strings that are used throughout phpScheduleit.
// Please save the translated file as '2 letter language code'.lang.php.  For example, en.lang.php.
// 
// To make phpScheduleIt available in another language, simply translate each
//  of the following strings into the appropriate one for the language.  If there
//  is no direct translation, please provide the closest translation.  Please be sure
//  to make the proper additions the /config/langs.php file (instructions are in the file).
//  Also, please add a help translation for your language using en.help.php as a base.
//
// You will probably keep all sprintf (%s) tags in their current place.  These tags
//  are there as a substitution placeholder.  Please check the output after translating
//  to be sure that the sentences make sense.
//
// + Please use single quotes ' around all $strings.  If you need to use the ' character, please enter it as \'
// + Please use double quotes " around all $email.  If you need to use the " character, please enter it as \"
//
// + For all $dates please use the PHP strftime() syntax
//    http://us2.php.net/manual/en/function.strftime.php
//
// + Non-intuitive parts of this file will be explained with comments.  If you
//    have any questions, please email lqqkout13@users.sourceforge.net
//    or post questions in the Developers forum on SourceForge
//    http://sourceforge.net/forum/forum.php?forum_id=331297
///////////////////////////////////////////////////////////

////////////////////////////////
/* Do not modify this section */
////////////////////////////////
global $strings;			  //
global $email;				  //
global $dates;				  //
global $charset;			  //
global $letters;			  //
global $days_full;			  //
global $days_abbr;			  //
global $days_two;			  //
global $days_letter;		  //
global $months_full;		  //
global $months_abbr;		  //
global $days_letter;		  //
/******************************/

// Charset for this language
// 'iso-8859-1' will work for most languages
$charset = 'iso-8859-1';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('&#51068;&#50836;&#51068;', '&#50900;&#50836;&#51068;', '&#54868;&#50836;&#51068;', '&#49688;&#50836;&#51068;', '&#47785;&#50836;&#51068;', '&#44552;&#50836;&#51068;', '&#53664;&#50836;&#51068;');
// The three letter abbreviation
$days_abbr = array('&#51068;', '&#50900;', '&#54868;', '&#49688;', '&#47785;', '&#44552;', '&#53664;');
// The two letter abbreviation
$days_two  = array('&#51068;', '&#50900;', '&#54868;', '&#49688;', '&#47785;', '&#44552;', '&#53664;');
// The one letter abbreviation
$days_letter = array('S', 'M', 'T', 'W', 'T', 'F', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('&#54644;&#50724;&#47492;&#45804;(1)', '&#49884;&#49368;&#45804;(2)', '&#47932;&#50724;&#47492;&#45804;(3)', '&#51086;&#49352;&#45804;(4)', '&#54392;&#47480;&#45804;(5)', '&#45572;&#47532;&#45804;(6)', '&#44204;&#50864;&#51649;&#45376;&#45804;(7)', '&#53440;&#50724;&#47492;&#45804;(8)', '&#50676;&#47588;&#45804;(9)', '&#54616;&#45720;&#50672;&#45804;(10)', '&#48120;&#53960;&#45804;(11)', '&#47588;&#46317;&#45804;(12)');
// The three letter month name
$months_abbr = array('1&#50900;', '2&#50900;', '3&#50900;', '4&#50900;', '5&#50900;', '6&#50900;', '7&#50900;', '8&#50900;', '9&#50900;', '10&#50900;', '11&#50900;', '12&#50900;');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%m/%d/%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%m/%d/%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %m/%d/%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%m/%d/%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%m %d %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = '&#49884;';
$strings['minutes'] = '&#48516;';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'yyyy';
$strings['am'] = '&#50724;&#51204;';
$strings['pm'] = '&#50724;&#54980;';

$strings['Administrator'] = '&#44288;&#47532;&#51088;';
$strings['Welcome Back'] = 'Welcome Back, %s';
$strings['Log Out'] = '&#47196;&#44536;&#50500;&#50883;';
$strings['My Control Panel'] = '&#45236; &#51228;&#50612;&#54032;';
$strings['Help'] = '&#46020;&#50880;&#47568;';
$strings['Manage Schedules'] = '&#49828;&#52992;&#51460; &#44288;&#47532;';
$strings['Manage Users'] = '&#49324;&#50857;&#51088; &#44288;&#47532;';
$strings['Manage Resources'] = '&#51088;&#50896; &#44288;&#47532;';
$strings['Manage User Training'] = 'Manage User Training';
$strings['Manage Reservations'] = '&#50696;&#50557; &#44288;&#47532;';
$strings['Email Users'] = '&#51060;&#47700;&#51068; &#49324;&#50857;&#51088;';
$strings['Export Database Data'] = 'DB &#51088;&#47308; &#45236;&#48372;&#45236;&#44592;';
$strings['Reset Password'] = '&#54056;&#49828;&#50892;&#46300; &#51116;&#49444;&#51221;';
$strings['System Administration'] = '&#49884;&#49828;&#53596; &#44288;&#47532;&#51088;';
$strings['Successful update'] = '&#50629;&#45936;&#51060;&#53944;&#44032; &#50756;&#47308;&#46104;&#50632;&#49845;&#45768;&#45796;';
$strings['Update failed!'] = '&#50629;&#45936;&#51060;&#53944;&#47484; &#54616;&#51648; &#47803;&#54664;&#49845;&#45768;&#45796;!';
$strings['Manage Blackout Times'] = 'Manage Blackout Times';
$strings['Forgot Password'] = '&#54056;&#49828;&#50892;&#46300; &#48516;&#49892;';
$strings['Manage My Email Contacts'] = '&#45236; &#51060;&#47700;&#51068; &#50672;&#46973;&#52376; &#44288;&#47532;';
$strings['Choose Date'] = '&#45216;&#51676; &#49440;&#53469;';
$strings['Modify My Profile'] = '&#45236; &#54532;&#47196;&#54596; &#49688;&#51221;';
$strings['Register'] = '&#46321;&#47197;';
$strings['Processing Blackout'] = 'Processing Blackout';
$strings['Processing Reservation'] = '&#50696;&#50557; &#49892;&#54665;';
$strings['Online Scheduler [Read-only Mode]'] = '&#50728;&#46972;&#51064; &#51068;&#51221;&#44288;&#47532; [&#51069;&#44592;&#51204;&#50857;]';
$strings['Online Scheduler'] = '&#50728;&#46972;&#51064; &#51068;&#51221;&#44288;&#47532;';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt &#53685;&#44228;';
$strings['User Info'] = '&#49324;&#50857;&#51088; &#51221;&#48372;:';

$strings['Could not determine tool'] = 'Could not determine tool. Please return to My Control Panel and try again later.';
$strings['This is only accessable to the administrator'] = '&#44288;&#47532;&#51088;&#47564; &#49324;&#50857;&#54624; &#49688; &#51080;&#49845;&#45768;&#45796;';
$strings['Back to My Control Panel'] = '&#45236; &#51228;&#50612;&#54032;&#51004;&#47196; &#46028;&#50500;&#44032;&#44592;';
$strings['That schedule is not available.'] = 'That schedule is not available.';
$strings['You did not select any schedules to delete.'] = '&#49325;&#51228;&#54624; &#51068;&#51221;&#47484; &#49440;&#53469;&#54616;&#49464;&#50836;.';
$strings['You did not select any members to delete.'] = '&#49325;&#51228;&#54624; &#44396;&#49457;&#50896;&#51012; &#49440;&#53469;&#54616;&#49464;&#50836;.';
$strings['You did not select any resources to delete.'] = '&#49325;&#51228;&#54624; &#47532;&#49548;&#49828;&#47484; &#49440;&#53469;&#54616;&#49464;&#50836;.';
$strings['Schedule title is required.'] = '&#51068;&#51221;&#51032; &#51228;&#47785;&#51060; &#54596;&#50836;&#54633;&#45768;&#45796;.';
$strings['Invalid start/end times'] = '&#49884;&#51089;/&#45149; &#49884;&#44036;&#51060; &#50732;&#48148;&#47476;&#51648; &#50506;&#49845;&#45768;&#45796;';
$strings['View days is required'] = 'View days is required';
$strings['Day offset is required'] = 'Day offset is required';
$strings['Admin email is required'] = '&#44288;&#47532;&#51088; &#51060;&#47700;&#51068;&#51008; &#54596;&#49688;&#49324;&#54637;&#51077;&#45768;&#45796;';
$strings['Resource name is required.'] = '&#51088;&#50896; &#51060;&#47492;&#51008; &#54596;&#49688;&#49324;&#54637;&#51077;&#45768;&#45796;';
$strings['Valid schedule must be selected'] = 'Valid schedule must be selected';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Minimum reservation length must be less than or equal to maximum reservation length.';
$strings['Your request was processed successfully.'] = 'Your request was processed successfully.';
$strings['Go back to system administration'] = '&#49884;&#49828;&#53596; &#44288;&#47532;&#47196; &#46028;&#50500;&#44032;&#44592;';
$strings['Or wait to be automatically redirected there.'] = 'Or wait to be automatically redirected there.';
$strings['There were problems processing your request.'] = 'There were problems processing your request.';
$strings['Please go back and correct any errors.'] = 'Please go back and correct any errors.';
$strings['Login to view details and place reservations'] = 'Login to view details and place reservations';
$strings['Memberid is not available.'] = 'Memberid: %s is not available.';

$strings['Schedule Title'] = '&#51068;&#51221; &#51228;&#47785;';
$strings['Start Time'] = '&#49884;&#51089;&#49884;&#44033;';
$strings['End Time'] = '&#51333;&#47308;&#49884;&#44033;';
$strings['Time Span'] = 'Time Span';
$strings['Weekday Start'] = 'Weekday Start';
$strings['Admin Email'] = '&#44288;&#47532;&#51088; &#51060;&#47700;&#51068;';

$strings['Default'] = '&#44592;&#48376;&#44050;';
$strings['Reset'] = '&#51116;&#49444;&#51221;';
$strings['Edit'] = '&#54200;&#51665;';
$strings['Delete'] = '&#49325;&#51228;';
$strings['Cancel'] = '&#52712;&#49548;';
$strings['View'] = '&#48372;&#44592;';
$strings['Modify'] = '&#49688;&#51221;';
$strings['Save'] = '&#51200;&#51109;';
$strings['Back'] = '&#46244;&#47196;';
$strings['Next'] = '&#45796;&#51020;';
$strings['Close Window'] = '&#52285; &#45803;&#44592;';
$strings['Search'] = '&#44160;&#49353;';
$strings['Clear'] = 'Clear';

$strings['Days to Show'] = 'Days to Show';
$strings['Reservation Offset'] = 'Reservation Offset';
$strings['Hidden'] = '&#44048;&#52628;&#44592;';
$strings['Show Summary'] = '&#50836;&#50557;&#51221;&#48372; &#48372;&#51060;&#44592;';
$strings['Add Schedule'] = '&#51068;&#51221; &#52628;&#44032;';
$strings['Edit Schedule'] = '&#51068;&#51221; &#54200;&#51665;';
$strings['No'] = '&#50500;&#45768;&#50724;';
$strings['Yes'] = '&#45348;';
$strings['Name'] = '&#51060;&#47492;';
$strings['First Name'] = '&#51060;&#47492;';
$strings['Last Name'] = '&#49457;';
$strings['Resource Name'] = '&#51088;&#50896; &#51060;&#47492;';
$strings['Email'] = '&#51060;&#47700;&#51068;';
$strings['Institution'] = 'Institution';
$strings['Phone'] = '&#51204;&#54868;';
$strings['Password'] = '&#54056;&#49828;&#50892;&#46300;';
$strings['Permissions'] = '&#44428;&#54620;';
$strings['View information about'] = 'View information about %s %s';
$strings['Send email to'] = 'Send email to %s %s';
$strings['Reset password for'] = 'Reset password for %s %s';
$strings['Edit permissions for'] = 'Edit permissions for %s %s';
$strings['Position'] = 'Position';
$strings['Password (6 char min)'] = 'Password (%s char min)';
$strings['Re-Enter Password'] = '&#54056;&#49828;&#50892;&#46300; &#51116;&#51077;&#47141;';

$strings['Sort by descending last name'] = '&#49457;&#50472;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending email address'] = '&#51060;&#47700;&#51068; &#51452;&#49548;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending institution'] = 'institution&#51004;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending last name'] = '&#49457;&#50472;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending email address'] = '&#51060;&#47700;&#51068; &#51452;&#49548;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending institution'] = 'institution&#51004;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending resource name'] = '&#51088;&#50896; &#51060;&#47492;&#51004;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending location'] = '&#50948;&#52824;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending schedule title'] = '&#51068;&#51221; &#51228;&#47785;&#51004;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending resource name'] = '&#51088;&#50896; &#51060;&#47492;&#51004;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending location'] = '&#50948;&#52824;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending schedule title'] = '&#51068;&#51221; &#51228;&#47785;&#51004;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending date'] = '&#45216;&#51676;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending user name'] = '&#49324;&#50857;&#51088; &#51060;&#47492;&#51004;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending start time'] = '&#49884;&#51089;&#49884;&#44033;&#51004;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending end time'] = '&#51333;&#47308;&#49884;&#44033;&#51004;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending date'] = '&#45216;&#51676;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending user name'] = '&#49324;&#50857;&#51088; &#51060;&#47492;&#51004;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending start time'] = '&#49884;&#51089;&#49884;&#44033;&#51004;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending end time'] = '&#51333;&#47308;&#49884;&#44033;&#51004;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending created time'] = '&#46321;&#47197;&#51068;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending created time'] = '&#46321;&#47197;&#51068;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by descending last modified time'] = '&#52572;&#51333;&#49688;&#51221;&#51068;&#47196; &#45236;&#47548;&#52264;&#49692; &#51221;&#47148;';
$strings['Sort by ascending last modified time'] = '&#52572;&#51333;&#49688;&#51221;&#51068;&#47196; &#50724;&#47492;&#52264;&#49692; &#51221;&#47148;';

$strings['Search Users'] = '&#49324;&#50857;&#51088; &#52286;&#44592;';
$strings['Location'] = '&#50948;&#52824;';
$strings['Schedule'] = '&#51068;&#51221;';
$strings['Notes'] = '&#47700;&#47784;';
$strings['Status'] = '&#49345;&#53468;';
$strings['All Schedules'] = '&#47784;&#46304; &#51068;&#51221;';
$strings['All Resources'] = '&#47784;&#46304; &#51088;&#50896;';
$strings['All Users'] = '&#47784;&#46304; &#49324;&#50857;&#51088;';

$strings['Edit data for'] = '%s&#51032; &#51088;&#47308; &#49688;&#51221;';
$strings['Active'] = '&#54876;&#49457;';
$strings['Inactive'] = '&#48708;&#54876;&#49457;';
$strings['Toggle this resource active/inactive'] = '&#51060; &#51088;&#50896;&#51012; &#54876;&#49457;/&#48708;&#54876;&#49457;(&#53664;&#44544;)';
$strings['Minimum Reservation Time'] = '&#52572;&#49548; &#50696;&#50557; &#49884;&#44036;';
$strings['Maximum Reservation Time'] = '&#52572;&#45824; &#50696;&#50557; &#49884;&#44036;';
$strings['Auto-assign permission'] = '&#44428;&#54620; &#51088;&#46041;&#54624;&#45817;';
$strings['Add Resource'] = '&#51088;&#50896; &#52628;&#44032;';
$strings['Edit Resource'] = '&#51088;&#50896; &#54200;&#51665;';
$strings['Allowed'] = '&#54728;&#50857;';
$strings['Notify user'] = 'Notify user';
$strings['User Reservations'] = '&#49324;&#50857;&#51088; &#50696;&#50557;';
$strings['Date'] = '&#45216;&#51676;';
$strings['User'] = '&#49324;&#50857;&#51088;';
$strings['Subject'] = '&#51228;&#47785;';
$strings['Message'] = '&#47700;&#49884;&#51648;';
$strings['Please select users'] = '&#49324;&#50857;&#51088;&#47484; &#49440;&#53469;&#54616;&#49464;&#50836;';
$strings['Send Email'] = '&#47700;&#51068; &#48372;&#45236;&#44592;';
$strings['problem sending email'] = '&#47700;&#51068;&#51012; &#48372;&#45236;&#45716;&#45936; &#50724;&#47448;&#44032; &#48156;&#49373;&#54664;&#49845;&#45768;&#45796;. &#45796;&#49884; &#54620;&#48264; &#49884;&#46020;&#54644;&#51452;&#49884;&#44592; &#48148;&#46989;&#45768;&#45796;.';
$strings['The email sent successfully.'] = '&#47700;&#51068;&#51012; &#48156;&#49569;&#54664;&#49845;&#45768;&#45796;.';
$strings['do not refresh page'] = '&#51060; &#54168;&#51060;&#51648;&#47484; &#49352;&#47196;&#44256;&#52840; <u>&#54616;&#51648; &#47560;&#49901;&#49884;&#50724;.</u> &#44536;&#47111;&#51648; &#50506;&#51004;&#47732; &#47700;&#51068;&#51060; &#45796;&#49884; &#48156;&#49569;&#46121;&#45768;&#45796;.';
$strings['Return to email management'] = '&#51060;&#47700;&#51068; &#44288;&#47532;&#47196; &#46028;&#50500;&#44032;&#44592;';
$strings['Please select which tables and fields to export'] = '&#45236;&#48372;&#45244; &#53580;&#51060;&#48660;&#44284; &#54596;&#46300;&#47484; &#49440;&#53469;&#54644;&#51452;&#49464;&#50836;:';
$strings['all fields'] = '- &#47784;&#46304; &#54596;&#46300; -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = '&#51068;&#48152; &#53581;&#49828;&#53944;';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = '&#45936;&#51060;&#53440; &#45236;&#48372;&#45236;&#44592;';
$strings['Reset Password for'] = '%s&#51032; &#54056;&#49828;&#50892;&#46300; &#51116;&#49444;&#51221;';
$strings['Please edit your profile'] = '&#54532;&#47196;&#54596;&#51012; &#54200;&#51665;&#54644;&#51452;&#49464;&#50836;';
$strings['Please register'] = '&#46321;&#47197;&#54644;&#51452;&#49464;&#50836;';
$strings['Email address (this will be your login)'] = '&#51060;&#47700;&#51068; &#51452;&#49548; (&#47196;&#44536;&#51064; &#44228;&#51221;&#51004;&#47196; &#49324;&#50857;&#46121;&#45768;&#45796;)';
$strings['Keep me logged in'] = '&#51088;&#46041; &#47196;&#44536;&#51064; <br/>(&#53216;&#53412;&#44032; &#44032;&#45733;&#54644;&#50556;&#54633;&#45768;&#45796;)';
$strings['Edit Profile'] = '&#54532;&#47196;&#54596; &#54200;&#51665;';
$strings['Please Log In'] = '&#47196;&#44536;&#51064; &#54644;&#51452;&#49464;&#50836;';
$strings['Email address'] = '&#51060;&#47700;&#51068; &#51452;&#49548;';
$strings['First time user'] = '&#52376;&#51020; &#49324;&#50857;&#54616;&#49901;&#45768;&#44620;?';
$strings['Click here to register'] = '&#46321;&#47197;&#54616;&#47140;&#47732; &#50668;&#44592;&#47484; &#53364;&#47533;&#54616;&#49464;&#50836;';
$strings['Register for phpScheduleIt'] = 'Register for phpScheduleIt';
$strings['Log In'] = '&#47196;&#44536;&#51064;';
$strings['View Schedule'] = '&#51068;&#51221; &#48372;&#44592;';
$strings['View a read-only version of the schedule'] = 'View a read-only version of the schedule';
$strings['I Forgot My Password'] = '&#54056;&#49828;&#50892;&#46300;&#47484; &#48516;&#49892;&#54664;&#49845;&#45768;&#45796;';
$strings['Retreive lost password'] = 'Retreive lost password';
$strings['Get online help'] = '&#50728;&#46972;&#51064; &#46020;&#50880;&#47568; &#48372;&#44592;';
$strings['Language'] = '&#50616;&#50612;';
$strings['(Default)'] = '(&#44592;&#48376;&#44050;)';

$strings['My Announcements'] = 'My Announcements';
$strings['My Reservations'] = '&#45236; &#50696;&#50557;';
$strings['My Permissions'] = '&#45236; &#44428;&#54620;';
$strings['My Quick Links'] = '&#45236; &#48736;&#47480;&#47553;&#53356;';
$strings['Announcements as of'] = 'Announcements as of %s';
$strings['There are no announcements.'] = 'There are no announcements.';
$strings['Resource'] = '&#51088;&#50896;';
$strings['Created'] = '&#46321;&#47197;&#51068;';
$strings['Last Modified'] = '&#52572;&#51333;&#49688;&#51221;&#51068;';
$strings['View this reservation'] = '&#51060; &#50696;&#50557; &#48372;&#44592;';
$strings['Modify this reservation'] = '&#51060; &#50696;&#50557; &#49688;&#51221;';
$strings['Delete this reservation'] = '&#51060; &#50696;&#50557; &#49325;&#51228;';
$strings['Bookings'] = 'Bookings';
$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
$strings['Mass Email Users'] = 'Mass Email Users';
$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
$strings['Export Database Content'] = 'DB &#52968;&#53584;&#52768; &#45236;&#48372;&#45236;&#44592;';
$strings['View System Stats'] = '&#49884;&#49828;&#53596; &#53685;&#44228; &#48372;&#44592;';
$strings['Email Administrator'] = '&#51060;&#47700;&#51068; &#44288;&#47532;&#51088;';

$strings['Email me when'] = '&#51060;&#47700;&#51068;&#47196; &#50508;&#47548;:';
$strings['I place a reservation'] = 'I place a reservation';
$strings['My reservation is modified'] = 'My reservation is modified';
$strings['My reservation is deleted'] = 'My reservation is deleted';
$strings['I prefer'] = 'I prefer:';
$strings['Your email preferences were successfully saved'] = 'Your email preferences were successfully saved!';
$strings['Return to My Control Panel'] = '&#45236; &#51228;&#50612;&#54032;&#51004;&#47196; &#46028;&#50500;&#44032;&#44592;';

$strings['Please select the starting and ending times'] = 'Please select the starting and ending times:';
$strings['Please change the starting and ending times'] = 'Please change the starting and ending times:';
$strings['Reserved time'] = 'Reserved time:';
$strings['Minimum Reservation Length'] = 'Minimum Reservation Length:';
$strings['Maximum Reservation Length'] = 'Maximum Reservation Length:';
$strings['Reserved for'] = 'Reserved for:';
$strings['Will be reserved for'] = 'Will be reserved for:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Update all recurring records in group?';
$strings['Delete?'] = '&#49325;&#51228;&#54616;&#49884;&#44192;&#49845;&#45768;&#44620;?';
$strings['Never'] = '-- Never --';
$strings['Days'] = '&#51068;';
$strings['Weeks'] = '&#51452;';
$strings['Months (date)'] = '&#50900; (date)';
$strings['Months (day)'] = '&#50900; (day)';
$strings['First Days'] = 'First Days';
$strings['Second Days'] = 'Second Days';
$strings['Third Days'] = 'Third Days';
$strings['Fourth Days'] = 'Fourth Days';
$strings['Last Days'] = 'Last Days';
$strings['Repeat every'] = 'Repeat every:';
$strings['Repeat on'] = 'Repeat on:';
$strings['Repeat until date'] = 'Repeat until date:';
$strings['Summary'] = '&#50836;&#50557;';

$strings['View schedule'] = 'View schedule:';
$strings['My Reservations'] = 'My Reservations';
$strings['My Past Reservations'] = 'My Past Reservations';
$strings['Other Reservations'] = 'Other Reservations';
$strings['Other Past Reservations'] = 'Other Past Reservations';
$strings['Blacked Out Time'] = 'Blacked Out Time';
$strings['Set blackout times'] = 'Set blackout times for %s on %s'; 
$strings['Reserve on'] = 'Reserve %s on %s';
$strings['Prev Week'] = '&laquo; Prev Week';
$strings['Jump 1 week back'] = 'Jump 1 week back';
$strings['Prev days'] = '&#8249; Prev %d days';
$strings['Previous days'] = '&#8249; Previous %d days';
$strings['This Week'] = 'This Week';
$strings['Jump to this week'] = 'Jump to this week';
$strings['Next days'] = 'Next %d days &#8250;';
$strings['Next Week'] = 'Next Week &raquo;';
$strings['Jump To Date'] = 'Jump To Date';
$strings['View Monthly Calendar'] = 'View Monthly Calendar';
$strings['Open up a navigational calendar'] = 'Open up a navigational calendar';

$strings['View stats for schedule'] = 'View stats for schedule:';
$strings['At A Glance'] = 'At A Glance';
$strings['Total Users'] = 'Total Users:';
$strings['Total Resources'] = 'Total Resources:';
$strings['Total Reservations'] = 'Total Reservations:';
$strings['Max Reservation'] = 'Max Reservation:';
$strings['Min Reservation'] = 'Min Reservation:';
$strings['Avg Reservation'] = 'Avg Reservation:';
$strings['Most Active Resource'] = 'Most Active Resource:';
$strings['Most Active User'] = 'Most Active User:';
$strings['System Stats'] = 'System Stats';
$strings['phpScheduleIt version'] = 'phpScheduleIt version:';
$strings['Database backend'] = 'Database backend:';
$strings['Database name'] = 'Database name:';
$strings['PHP version'] = 'PHP version:';
$strings['Server OS'] = 'Server OS:';
$strings['Server name'] = 'Server name:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt root directory:';
$strings['Using permissions'] = 'Using permissions:';
$strings['Using logging'] = 'Using logging:';
$strings['Log file'] = 'Log file:';
$strings['Admin email address'] = 'Admin email address:';
$strings['Tech email address'] = 'Tech email address:';
$strings['CC email addresses'] = 'CC email addresses:';
$strings['Reservation start time'] = 'Reservation start time:';
$strings['Reservation end time'] = 'Reservation end time:';
$strings['Days shown at a time'] = 'Days shown at a time:';
$strings['Reservations'] = 'Reservations';
$strings['Return to top'] = 'Return to top';
$strings['for'] = 'for';

$strings['Select Search Criteria'] = 'Select Search Criteria';
$strings['Schedules'] = 'Schedules:';
$strings['All Schedules'] = 'All Schedules';
$strings['Hold CTRL to select multiple'] = 'Hold CTRL to select multiple';
$strings['Users'] = 'Users:';
$strings['All Users'] = 'All Users';
$strings['Resources'] = 'Resources';
$strings['All Resources'] = 'All Resources';
$strings['Starting Date'] = 'Starting Date:';
$strings['Ending Date'] = 'Ending Date:';
$strings['Starting Time'] = 'Starting Time:';
$strings['Ending Time'] = 'Ending Time:';
$strings['Output Type'] = 'Output Type:';
$strings['Manage'] = 'Manage';
$strings['Total Time'] = 'Total Time';
$strings['Total hours'] = 'Total hours:';
$strings['% of total resource time'] = '% of total resource time';
$strings['View these results as'] = 'View these results as:';
$strings['Edit this reservation'] = 'Edit this reservation';
$strings['Search Results'] = 'Search Results';
$strings['Search Resource Usage'] = 'Search Resource Usage';
$strings['Search Results found'] = 'Search Results: %d reservations found';
$strings['Try a different search'] = 'Try a different search';
$strings['Search Run On'] = 'Search Run On:';
$strings['Member ID'] = 'Member ID';
$strings['Previous User'] = '&laquo; Previous User';
$strings['Next User'] = 'Next User &raquo;';

$strings['No results'] = 'No results';
$strings['That record could not be found.'] = 'That record could not be found.';
$strings['This blackout is not recurring.'] = 'This blackout is not recurring.';
$strings['This reservation is not recurring.'] = 'This reservation is not recurring.';
$strings['There are no records in the table.'] = 'There are no records in the %s table.';
$strings['You do not have any reservations scheduled.'] = 'You do not have any reservations scheduled.';
$strings['You do not have permission to use any resources.'] = 'You do not have permission to use any resources.';
$strings['No resources in the database.'] = 'No resources in the database.';
$strings['There was an error executing your query'] = 'There was an error executing your query:';

$strings['That cookie seems to be invalid'] = 'That cookie seems to be invalid';
$strings['We could not find that email in our database.'] = 'We could not find that email in our database.';
$strings['That password did not match the one in our database.'] = 'That password did not match the one in our database.';
$strings['You can try'] = '<br />You can try:<br />Registering an email address.<br />Or:<br />Try logging in again.';
$strings['A new user has been added'] = 'A new user has been added';
$strings['You have successfully registered'] = 'You have successfully registered!';
$strings['Continue'] = 'Continue...';
$strings['Your profile has been successfully updated!'] = 'Your profile has been successfully updated!';
$strings['Please return to My Control Panel'] = 'Please return to My Control Panel';
$strings['Valid email address is required.'] = '- Valid email address is required.';
$strings['First name is required.'] = '- First name is required.';
$strings['Last name is required.'] = '- Last name is required.';
$strings['Phone number is required.'] = '- Phone number is required.';
$strings['That email is taken already.'] = '- That email is taken already.<br />Please try again with a different email address.';
$strings['Min 6 character password is required.'] = '- Min %s character password is required.';
$strings['Passwords do not match.'] = '- Passwords do not match.';

$strings['Per page'] = 'Per page:';
$strings['Page'] = 'Page:';

$strings['Your reservation was successfully created'] = 'Your reservation was successfully created';
$strings['Your reservation was successfully modified'] = 'Your reservation was successfully modified';
$strings['Your reservation was successfully deleted'] = 'Your reservation was successfully deleted';
$strings['Your blackout was successfully created'] = 'Your blackout was successfully created';
$strings['Your blackout was successfully modified'] = 'Your blackout was successfully modified';
$strings['Your blackout was successfully deleted'] = 'Your blackout was successfully deleted';
$strings['for the follwing dates'] = 'for the follwing dates:';
$strings['Start time must be less than end time'] = 'Start time must be less than end time.';
$strings['Current start time is'] = 'Current start time is:';
$strings['Current end time is'] = 'Current end time is:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Reservation length does not fall within this resource\'s allowed length.';
$strings['Your reservation is'] = 'Your reservation is:';
$strings['Minimum reservation length'] = 'Minimum reservation length:';
$strings['Maximum reservation length'] = 'Maximum reservation length:';
$strings['You do not have permission to use this resource.'] = 'You do not have permission to use this resource.';
$strings['reserved or unavailable'] = '%s from %s to %s is reserved or unavailable.';
$strings['Reservation created for'] = 'Reservation created for %s';
$strings['Reservation modified for'] = 'Reservation modified for %s';
$strings['Reservation deleted for'] = 'Reservation deleted for %s';
$strings['created'] = 'created';
$strings['modified'] = 'modified';
$strings['deleted'] = 'deleted';
$strings['Reservation #'] = 'Reservation #';
$strings['Contact'] = 'Contact';
$strings['Reservation created'] = 'Reservation created';
$strings['Reservation modified'] = 'Reservation modified';
$strings['Reservation deleted'] = 'Reservation deleted';

$strings['Reservations by month'] = 'Reservations by month';
$strings['Reservations by day of the week'] = 'Reservations by day of the week';
$strings['Reservations per month'] = 'Reservations per month';
$strings['Reservations per user'] = 'Reservations per user';
$strings['Reservations per resource'] = 'Reservations per resource';
$strings['Reservations per start time'] = 'Reservations per start time';
$strings['Reservations per end time'] = 'Reservations per end time';
$strings['[All Reservations]'] = '[All Reservations]';

$strings['Permissions Updated'] = 'Permissions Updated';
$strings['Your permissions have been updated'] = 'Your %s permissions have been updated';
$strings['You now do not have permission to use any resources.'] = 'You now do not have permission to use any resources.';
$strings['You now have permission to use the following resources'] = 'You now have permission to use the following resources:';
$strings['Please contact with any questions.'] = 'Please contact %s with any questions.';
$strings['Password Reset'] = 'Password Reset';

$strings['This will change your password to a new, randomly generated one.'] = 'This will change your password to a new, randomly generated one.';
$strings['your new password will be set'] = 'After entering your email address and clicking "Change Password", your new password will be set in the system and emailed to you.';
$strings['Change Password'] = 'Change Password';
$strings['Sorry, we could not find that user in the database.'] = 'Sorry, we could not find that user in the database.';
$strings['Your New Password'] = 'Your New %s Password';
$strings['Your new passsword has been emailed to you.'] = 'Success!<br />'
    			. 'Your new passsword has been emailed to you.<br />'
    			. 'Please check your mailbox for your new password, then <a href="index.php">Log In</a>'
    			. ' with this new password and promptly change it by clicking the &quot;Change My Profile Information/Password&quot;'
    			. ' link in My Control Panel.';

$strings['You are not logged in!'] = 'You are not logged in!';

$strings['Setup'] = 'Setup';
$strings['Please log into your database'] = 'Please log into your database';
$strings['Enter database root username'] = 'Enter database root username:';
$strings['Enter database root password'] = 'Enter database root password:';
$strings['Login to database'] = 'Login to database';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Root user is <b>not</b> required. Any database user who has permission to create tables is acceptable.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'This will set up all the necessary databases and tables for phpScheduleIt.';
$strings['It also populates any required tables.'] = 'It also populates any required tables.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!';
$strings['Not a valid database type in the config.php file.'] = 'Not a valid database type in the config.php file.';
$strings['Database user password is not set in the config.php file.'] = 'Database user password is not set in the config.php file.';
$strings['Database name not set in the config.php file.'] = 'Database name not set in the config.php file.';
$strings['Successfully connected as'] = 'Successfully connected as';
$strings['Create tables'] = 'Create tables &gt;';
$strings['There were errors during the install.'] = 'There were errors during the install. It is possible that phpScheduleIt will still work if the errors were minor.<br/><br/>'
	. 'Please post any questions to the forums on <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'You have successfully finished setting up phpScheduleIt and are ready to begin using it.';
$strings['Thank you for using phpScheduleIt'] = 'Please be sure to COMPLETELY REMOVE THE \'install\' DIRECTORY.'
	. ' This is critical because it contains database passwords and other sensitive information.'
	. ' Failing to do so leaves the door wide open for anyone to break into your database!'
	. '<br /><br />'
	. 'Thank you for using phpScheduleIt!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.';
$strings['There is no way to undo this action'] = 'There is no way to undo this action!';
$strings['Click to proceed'] = 'Click to proceed';
$strings['This version has already been upgraded to 1.0.0.'] = 'This version has already been upgraded to 1.0.0.';
$strings['Please delete this file.'] = 'Please delete this file.';
$strings['Successful update'] = 'The update succeeded fully';
$strings['Patch completed successfully'] = 'Patch completed successfully';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'
		. '<br />It is only required to run this if you performed a manual SQL update or are upgrading from 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'If no value is specified, the default password set in the config file will be used.';
$strings['Notify user that password has been changed?'] = 'Notify user that password has been changed?';
// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'This system requires that you have an email address.';
$strings['Invalid User Name/Password.'] = 'Invalid User Name/Password.';
$strings['Pending User Reservations'] = 'Pending User Reservations';
$strings['Approve'] = 'Approve';
$strings['Approve this reservation'] = 'Approve this reservation';
$strings['Approve Reservations'] ='Approve Reservations';

$strings['Announcement'] = 'Announcement';
$strings['Number'] = 'Number';
$strings['Add Announcement'] = 'Add Announcement';
$strings['Edit Announcement'] = 'Edit Announcement';
$strings['All Announcements'] = 'All Announcements';
$strings['Delete Announcements'] = 'Delete Announcements';
$strings['Use start date/time?'] = 'Use start date/time?';
$strings['Use end date/time?'] = 'Use end date/time?';
$strings['Announcement text is required.'] = 'Announcement text is required.';
$strings['Announcement number is required.'] = 'Announcement number is required.';

$strings['Pending Approval'] = 'Pending Approval';
$strings['My reservation is approved'] = 'My reservation is approved';
$strings['This reservation must be approved by the administrator.'] = 'This reservation must be approved by the administrator.';
$strings['Approval Required'] = 'Approval Required';
$strings['No reservations requiring approval'] = 'No reservations requiring approval';
$strings['Your reservation was successfully approved'] = 'Your reservation was successfully approved';
$strings['Reservation approved for'] = 'Reservation approved for %s';
$strings['approved'] = 'approved';
$strings['Reservation approved'] = 'Reservation approved';

$strings['Valid username is required'] = 'Valid username is required';
$strings['That logon name is taken already.'] = 'That logon name is taken already.';
$strings['this will be your login'] = '(this will be your login)';
$strings['Logon name'] = 'Logon name';
$strings['Your logon name is'] = 'Your logon name is %s';

$strings['Start'] = 'Start';
$strings['End'] = 'End';
$strings['Start date must be less than or equal to end date'] = 'Start date must be less than or equal to end date';
$strings['That starting date has already passed'] = 'That starting date has already passed';
$strings['Basic'] = 'Basic';
$strings['Participants'] = 'Participants';
$strings['Close'] = 'Close';
$strings['Start Date'] = 'Start Date';
$strings['End Date'] = 'End Date';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Allow Multiple Day Reservations';
$strings['Invited Users'] = 'Invited Users';
$strings['Invite Users'] = 'Invite Users';
$strings['Remove Participants'] = 'Remove Participants';
$strings['Reservation Invitation'] = 'Reservation Invitation';
$strings['Manage Invites'] = 'Manage Invites';
$strings['No invite was selected'] = 'No invite was selected';
$strings['reservation accepted'] = '%s Accepted Your Invitation on %s';
$strings['reservation declined'] = '%s Declined Your Invitation on %s';
$strings['Login to manage all of your invitiations'] = 'Login to manage all of your invitations';
$strings['Reservation Participation Change'] = 'Reservation Participation Change';
$strings['My Invitations'] = 'My Invitations';
$strings['Accept'] = 'Accept';
$strings['Decline'] = 'Decline';
$strings['Accept or decline this reservation'] = 'Accept or decline this reservation';
$strings['My Reservation Participation'] = 'My Reservation Participation';
$strings['End Participation'] = 'End Participation';
$strings['Owner'] = 'Owner';
$strings['Particpating Users'] = 'Participating Users';
$strings['No advanced options available'] = 'No advanced options available';
$strings['Confirm reservation participation'] = 'Confirm reservation participation';
$strings['Confirm'] = 'Confirm';
$strings['Do for all reservations in the group?'] = 'Do for all reservations in the group?';

$strings['My Calendar'] = 'My Calendar';
$strings['View My Calendar'] = 'View My Calendar';
$strings['Participant'] = 'Participant';
$strings['Recurring'] = 'Recurring';
$strings['Multiple Day'] = 'Multiple Day';
$strings['[today]'] = '[today]';
$strings['Day View'] = 'Day View';
$strings['Week View'] = 'Week View';
$strings['Month View'] = 'Month View';
$strings['Resource Calendar'] = 'Resource Calendar';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Signup View';

$strings['Select User'] = 'Select User';
$strings['Change'] = 'Change';

$strings['Update'] = 'Update';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Update is only available for versions 1.0.0 or later';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt is already up to date';
$strings['Migrating reservations'] = 'Migrating reservations';

$strings['Admin'] = 'Admin';
$strings['Manage Announcements'] = 'Manage Announcements';
$strings['There are no announcements'] = 'There are no announcements';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximum Participant Capacity';
$strings['Leave blank for unlimited'] = 'Leave blank for unlimited';
$strings['Maximum of participants'] = 'This resource has a maximum capacity of %s participants';
$strings['That reservation is at full capacity.'] = 'That reservation is at full capacity.';
$strings['Allow registered users to join?'] = 'Allow registered users to join?';
$strings['Allow non-registered users to join?'] = 'Allow non-registered users to join?';
$strings['Join'] = 'Join';
$strings['My Participation Options'] = 'My Participation Options';
$strings['Join Reservation'] = 'Join Reservation';
$strings['Join All Recurring'] = 'Join All Recurring';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'You are not participating on the following reservation dates because they are at full capacity.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'You are already invited to this reservation. Please follow participation instructions previously sent to your email.';
$strings['Additional Tools'] = 'Additional Tools';
$strings['Create User'] = 'Create User';
$strings['Check Availability'] = 'Check Availability';
$strings['Manage Additional Resources'] = 'Manage Additional Resources';
$strings['All Additional Resources'] = 'All Additional Resources';
$strings['Number Available'] = 'Number Available';
$strings['Unlimited'] = 'Unlimited';
$strings['Add Additional Resource'] = 'Add Additional Resource';
$strings['Edit Additional Resource'] = 'Edit Additional Resource';
$strings['Checking'] = 'Checking';
$strings['You did not select anything to delete.'] = 'You did not select anything to delete.';
$strings['Added Resources'] = 'Added Resources';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'All Groups';
$strings['Group Name'] = 'Group Name';
$strings['Delete Groups'] = 'Delete Groups';
$strings['Manage Groups'] = 'Manage Groups';
$strings['None'] = 'None';
$strings['Group name is required.'] = 'Group name is required.';
$strings['Groups'] = 'Groups';
$strings['Current Groups'] = 'Current Groups';
$strings['Group Administration'] = 'Group Administration';
$strings['Reminder Subject'] = 'Reservation reminder- %s, %s %s';
$strings['Reminder'] = 'Reminder';
$strings['before reservation'] = 'before reservation';
$strings['My Participation'] = 'My Participation';
$strings['My Past Participation'] = 'My Past Participation';
$strings['Timezone'] = 'Timezone';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Select reservations to export';
$strings['Export Format'] = 'Export Format';
$strings['This resource cannot be reserved less than x hours in advance'] = 'This resource cannot be reserved less than %s hours in advance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'This resource cannot be reserved more than %s hours in advance';
$strings['Minimum Booking Notice'] = 'Minimum Booking Notice';
$strings['Maximum Booking Notice'] = 'Maximum Booking Notice';
$strings['hours prior to the start time'] = 'hours prior to the start time';
$strings['hours from the current time'] = 'hours from the current time';
$strings['Contains'] = 'Contains';
$strings['Begins with'] = 'Begins with';
$strings['Minimum booking notice is required.'] = 'Minimum booking notice is required.';
$strings['Maximum booking notice is required.'] = 'Maximum booking notice is required.';
$strings['Accessory Name'] = 'Accessory Name';
$strings['Accessories'] = 'Accessories';
$strings['All Accessories'] = 'All Accessories';
$strings['Added Accessories'] = 'Added Accessories';
// end since 1.2.0

/***
  EMAIL MESSAGES
  Please translate these email messages into your language.  You should keep the sprintf (%s) placeholders
   in their current position unless you know you need to move them.
  All email messages should be surrounded by double quotes "
  Each email message will be described below.
***/
// @since 1.1.0
// Email message that a user gets after they register
$email['register'] = "%s, %s \r\n"
				. "You have successfully registered with the following information:\r\n"
				. "Logon: %s\r\n"
				. "Name: %s %s \r\n"
				. "Phone: %s \r\n"
				. "Institution: %s \r\n"
				. "Position: %s \r\n\r\n"
				. "Please log into the scheduler at this location:\r\n"
				. "%s \r\n\r\n"
				. "You can find links to the online scheduler and to edit your profile at My Control Panel.\r\n\r\n"
				. "Please direct any resource or reservation based questions to %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrator,\r\n\r\n"
					. "A new user has registered with the following information:\r\n"
					. "Email: %s \r\n"
					. "Name: %s %s \r\n"
					. "Phone: %s \r\n"
					. "Institution: %s \r\n"
					. "Position: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "You have successfully %s reservation #%s.\r\n\r\n<br/><br/>"
			. "Please use this reservation number when contacting the administrator with any questions.\r\n\r\n<br/><br/>"
			. "A reservation between %s %s and %s %s for %s"
			. " located at %s has been %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "This reservation has been repeated on the following dates:\r\n<br/>";
$email['reservation_activity_3'] = "All recurring reservations in this group were also %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "The following summary was provided for this reservation:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "If this is a mistake, please contact the administrator at: %s"
			. " or by calling %s.\r\n\r\n<br/><br/>"
			. "You can view or modify your reservation information at any time by"
			. " logging into %s at:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Please direct all technical questions to <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Reservation #%s has been approved.\r\n\r\n<br/><br/>"
			. "Please use this reservation number when contacting the administrator with any questions.\r\n\r\n<br/><br/>"
			. "A reservation between %s %s and %s %s for %s"
			. " located at %s has been %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Your %s password has been reset by the administrator.\r\n\r\n"
			. "Your temporary password is:\r\n\r\n %s\r\n\r\n"
			. "Please use this temporary password (copy and paste to be sure it is correct) to log into %s at %s"
			. " and immediately change it using the 'Change My Profile Information/Password' link in the My Quick Links table.\r\n\r\n"
			. "Please contact %s with any questions.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Your new password for your %s account is:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Please Log In at %s "
            . "with this new password "
            . "(copy and paste it to ensure it is correct) "
            . "and promptly change your password by clicking the "
            . "Change My Profile Information/Password "
            . "link in My Control Panel.\r\n\r\n"
            . "Please direct any questions to %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s has invited you to participate in the following reservation:\r\n\r\n"
		. "Resource: %s\r\n"
		. "Start Date: %s\r\n"
		. "Start Time: %s\r\n"
		. "End Date: %s\r\n"
		. "End Time: %s\r\n"
		. "Summary: %s\r\n"
		. "Repeated Dates (if present): %s\r\n\r\n"
		. "To accept this invitation click this link (copy and paste if it is not highlighted) %s\r\n"
		. "To decline this invitation click this link (copy and paste if it is not highlighted) %s\r\n"
		. "To accept select dates or manage your invitations at a later time, please log into %s at %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "You have been removed from the following reservation:\r\n\r\n"
		. "Resource: %s\r\n"
		. "Start Date: %s\r\n"
		. "Start Time: %s\r\n"
		. "End Date: %s\r\n"
		. "End Time: %s\r\n"
		. "Summary: %s\r\n"
		. "Repeated Dates (if present): %s\r\n\r\n";	
		
// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Your reservation for %s from %s %s to %s %s is approaching.";
?>