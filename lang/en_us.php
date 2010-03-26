<?php
require_once('Language.php');

class en_us extends Language
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function _LoadDates()
	{
		$dates = array();
		
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
		
		// new stuff
		$dates['js_general_date'] = 'mm/dd/yy';
		$dates['general_date'] = 'm/d/Y';
		$dates['schedule_daily'] = 'l, m/d/Y';
		$dates['period_time'] = "g:i A";
		$dates['url'] = 'Y-m-d';
		
		$this->Dates = $dates;
	}
	
	function _LoadStrings()
	{
		$strings = array();
		
		$strings['FirstName'] = 'First Name';
		$strings['LastName'] = 'Last Name';
		$strings['Timezone'] = 'Timezone';
		
		// new stuff
		$strings['FirstNameRequired'] = 'First name is required.';
		$strings['LastNameRequired'] = 'Last name is required.';
		$strings['PwMustMatch'] = 'Password confirmation must match password.';
		$strings['PwComplexity'] = 'Password must be at least 6 characters with a combination of letters, numbers and symbols.';
		$strings['ValidEmailRequired'] = 'A valid email address is required.';
		$strings['UniqueEmailRequired'] = 'That email address is already registered.';
		$strings['UniqueUsernameRequired'] = 'That user name is already registered.';
		$strings['Today'] = 'Today';
		$strings['BackToCalendar'] = 'Back to calendar';
		$strings['BeginDate'] = 'Begin';
		$strings['EndDate'] = 'End';
		$strings['Username'] = 'Username';
		$strings['Password'] = 'Password';
		$strings['PasswordConfirmation'] = 'Confirm Password';
		$strings['DefaultPage'] = 'Default Homepage';
		$strings['MyDashboard'] = 'My Dashboard';
		$strings['MyCalendar'] = 'My Calendar';
		$strings['ScheduleCalendar'] = 'Schedule Calendar';
		$strings['Registration'] = 'Registration';
		$strings['NoAnnouncements'] = 'There are no announcements';
		$strings['Announcements'] = 'Announcements';
		$strings['ShowHide'] = 'Show/Hide';
		$strings['Error'] = 'Error';
		$strings['ReturnToPreviousPage'] = 'Return to the last page that you were on';
		$strings['UnknownError'] = 'Unknown Error';
		$strings['InsufficientPermissionsError'] = 'You do not have permission to access this resource';
		
		// Page Titles
		$strings['CreateReservation'] = 'Create Reservation';
		$strings['LogIn'] = 'Log In';
		//
		
		/***
		  STRING TRANSLATIONS
		  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
		  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
		  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
		  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
		***/
		$strings['hours'] = 'hours';
		$strings['minutes'] = 'minutes';
		// The common abbreviation to hint that a user should enter the month as 2 digits
		$strings['mm'] = 'mm';
		// The common abbreviation to hint that a user should enter the day as 2 digits
		$strings['dd'] = 'dd';
		// The common abbreviation to hint that a user should enter the year as 4 digits
		$strings['yyyy'] = 'yyyy';
		$strings['am'] = 'am';
		$strings['pm'] = 'pm';
		
		$strings['Administrator'] = 'Administrator';
		$strings['Welcome Back'] = 'Welcome Back, %s';
		$strings['Log Out'] = 'Log Out';
		$strings['My Control Panel'] = 'My Control Panel';
		$strings['Help'] = 'Help';
		$strings['Manage Schedules'] = 'Manage Schedules';
		$strings['Manage Users'] = 'Manage Users';
		$strings['Manage Resources'] = 'Manage Resources';
		$strings['Manage Locations'] = 'Manage Locations';
		$strings['Manage User Training'] = 'Manage User Training';
		$strings['Manage Reservations'] = 'Manage Reservations';
		$strings['Email Users'] = 'Email Users';
		$strings['Export Database Data'] = 'Export Database Data';
		$strings['Reset Password'] = 'Reset Password';
		$strings['System Administration'] = 'System Administration';
		$strings['Successful update'] = 'Successful update';
		$strings['Update failed!'] = 'Update failed!';
		$strings['Manage Blackout Times'] = 'Manage Blackout Times';
		$strings['Forgot Password'] = 'Forgot Password';
		$strings['Manage My Email Contacts'] = 'Manage My Email Contacts';
		$strings['Choose Date'] = 'Choose Date';
		$strings['Modify My Profile'] = 'Modify My Profile';
		$strings['Register'] = 'Register';
		$strings['Processing Blackout'] = 'Processing Blackout';
		$strings['Processing Reservation'] = 'Processing Reservation';
		$strings['Online Scheduler [Read-only Mode]'] = 'Online Scheduler [Read-only Mode]';
		$strings['Online Scheduler'] = 'Online Scheduler';
		$strings['phpScheduleIt Statistics'] = 'phpScheduleIt Statistics';
		$strings['User Info'] = 'User Info:';
		
		$strings['ResourceName'] = 'Resource name';
		$strings['ResourceLocation'] = 'Location of resource';
		$strings['Description'] = 'Description of resource';
		$strings['ContactInfo'] = 'Contact information for resource';
		$strings['ResourceNotes'] = 'Additional notes';
		$strings['IsActive'] = 'Resource is currently available for reservations';
		$strings['MinDuration'] = 'Minimum duration of reservation';
		$strings['MinIncrement'] = 'Minimum increment of reservation';
		$strings['MaxDuration'] = 'Maximum duration of reservation';
		$strings['UnitCost'] = 'Time unit cost for resource';
		$strings['AutoAssign'] = 'Assign resource automatically';
		$strings['RequiresApproval'] = 'Reservation requires approval';
		$strings['MultidayReservations'] = 'Allow multiple day reservations';
		$strings['MaxParticipants'] = 'Maximum number of participants';
		$strings['MinNotice'] = 'Minimum notice time before reservation';
		$strings['MaxNotice'] = 'Maximum notice time before reservation';
		$strings['Constraints'] = 'Resource constraints';
		$strings['LongQuota'] = 'Period quota';
		$strings['DayQuota'] = 'Daily quota';
		
		$strings['Could not determine tool'] = 'Could not determine tool. Please return to My Control Panel and try again later.';
		$strings['This is only accessable to the administrator'] = 'This is only accessible to the administrator';
		$strings['Back to My Control Panel'] = 'Back to My Control Panel';
		$strings['That schedule is not available.'] = 'That schedule is not available.';
		$strings['You did not select any schedules to delete.'] = 'You did not select any schedules to delete.';
		$strings['You did not select any members to delete.'] = 'You did not select any members to delete.';
		$strings['You did not select any resources to delete.'] = 'You did not select any resources to delete.';
		$strings['Schedule title is required.'] = 'Schedule title is required.';
		$strings['Invalid start/end times'] = 'Invalid start/end times';
		$strings['View days is required'] = 'View days is required';
		$strings['Day offset is required'] = 'Day offset is required';
		$strings['Admin email is required'] = 'Admin email is required';
		$strings['Resource name is required.'] = 'Resource name is required.';
		$strings['Valid schedule must be selected'] = 'Valid schedule must be selected';
		$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Minimum reservation length must be less than or equal to maximum reservation length.';
		$strings['Your request was processed successfully.'] = 'Your request was processed successfully.';
		$strings['Go back to system administration'] = 'Go back to system administration';
		$strings['Or wait to be automatically redirected there.'] = 'Or wait to be automatically redirected there.';
		$strings['There were problems processing your request.'] = 'There were problems processing your request.';
		$strings['Please go back and correct any errors.'] = 'Please go back and correct any errors.';
		$strings['Login to view details and place reservations'] = 'Login to view details and place reservations';
		$strings['Memberid is not available.'] = 'Memberid: %s is not available.';
		
		$strings['Schedule Title'] = 'Schedule Title';
		$strings['Start Time'] = 'Start Time';
		$strings['End Time'] = 'End Time';
		$strings['Time Span'] = 'Time Span';
		$strings['Weekday Start'] = 'Weekday Start';
		$strings['Admin Email'] = 'Admin Email';
		
		$strings['Default'] = 'Default';
		$strings['Reset'] = 'Reset';
		$strings['Edit'] = 'Edit';
		$strings['Delete'] = 'Delete';
		$strings['Cancel'] = 'Cancel';
		$strings['View'] = 'View';
		$strings['Modify'] = 'Modify';
		$strings['Save'] = 'Save';
		$strings['Back'] = 'Back';
		$strings['Next'] = 'Next';
		$strings['Close Window'] = 'Close Window';
		$strings['Search'] = 'Search';
		$strings['Clear'] = 'Clear';
		
		$strings['Days to Show'] = 'Days to Show';
		$strings['Reservation Offset'] = 'Reservation Offset';
		$strings['Hidden'] = 'Hidden';
		$strings['Show Summary'] = 'Show Summary';
		$strings['Add Schedule'] = 'Add Schedule';
		$strings['Edit Schedule'] = 'Edit Schedule';
		$strings['No'] = 'No';
		$strings['Yes'] = 'Yes';
		$strings['Name'] = 'Name';
		$strings['First Name'] = 'First Name';
		$strings['Last Name'] = 'Last Name';
		$strings['Resource Name'] = 'Resource Name';
		$strings['Email'] = 'Email';
		$strings['Institution'] = 'Institution';
		$strings['Phone'] = 'Phone';
		$strings['Password'] = 'Password';
		$strings['Permissions'] = 'Permissions';
		$strings['View information about'] = 'View information about %s %s';
		$strings['Send email to'] = 'Send email to %s %s';
		$strings['Reset password for'] = 'Reset password for %s %s';
		$strings['Edit permissions for'] = 'Edit permissions for %s %s';
		$strings['Position'] = 'Position';
		$strings['Password (6 char min)'] = 'Password (%s char min)';	// @since 1.1.0
		$strings['Re-Enter Password'] = 'Re-Enter Password';
		
		$strings['Sort by descending last name'] = 'Sort by descending last name';
		$strings['Sort by descending email address'] = 'Sort by descending email address';
		$strings['Sort by descending institution'] = 'Sort by descending institution';
		$strings['Sort by ascending last name'] = 'Sort by ascending last name';
		$strings['Sort by ascending email address'] = 'Sort by ascending email address';
		$strings['Sort by ascending institution'] = 'Sort by ascending institution';
		$strings['Sort by descending resource name'] = 'Sort by descending resource name';
		$strings['Sort by descending location'] = 'Sort by descending location';
		$strings['Sort by descending schedule title'] = 'Sort by descending schedule title';
		$strings['Sort by ascending resource name'] = 'Sort by ascending resource name';
		$strings['Sort by ascending location'] = 'Sort by ascending location';
		$strings['Sort by ascending schedule title'] = 'Sort by ascending schedule title';
		$strings['Sort by descending date'] = 'Sort by descending date';
		$strings['Sort by descending user name'] = 'Sort by descending user name';
		$strings['Sort by descending start time'] = 'Sort by descending start time';
		$strings['Sort by descending end time'] = 'Sort by descending end time';
		$strings['Sort by ascending date'] = 'Sort by ascending date';
		$strings['Sort by ascending user name'] = 'Sort by ascending user name';
		$strings['Sort by ascending start time'] = 'Sort by ascending start time';
		$strings['Sort by ascending end time'] = 'Sort by ascending end time';
		$strings['Sort by descending created time'] = 'Sort by descending created time';
		$strings['Sort by ascending created time'] = 'Sort by ascending created time';
		$strings['Sort by descending last modified time'] = 'Sort by descending last modified time';
		$strings['Sort by ascending last modified time'] = 'Sort by ascending last modified time';
		
		$strings['Search Users'] = 'Search Users';
		$strings['Location'] = 'Location';
		$strings['Schedule'] = 'Schedule';
		$strings['Phone'] = 'Phone';
		$strings['Notes'] = 'Notes';
		$strings['Status'] = 'Status';
		$strings['Street1'] = 'Street1';
		$strings['Street2'] = 'Street2';
		$strings['City'] = 'City';
		$strings['State'] = 'State';
		$strings['Zip'] = 'Zip';
		$strings['Country'] = 'Country';
		$strings['All Schedules'] = 'All Schedules';
		$strings['All Resources'] = 'All Resources';
		$strings['All Locations'] = 'All Locations';
		$strings['All Users'] = 'All Users';
		
		$strings['Edit data for'] = 'Edit data for %s';
		$strings['Active'] = 'Active';
		$strings['Inactive'] = 'Inactive';
		$strings['Toggle this resource active/inactive'] = 'Toggle this resource active/inactive';
		$strings['Minimum Reservation Time'] = 'Minimum Reservation Time';
		$strings['Maximum Reservation Time'] = 'Maximum Reservation Time';
		$strings['Auto-assign permission'] = 'Auto-assign permission';
		$strings['Add Resource'] = 'Add Resource';
		$strings['Edit Resource'] = 'Edit Resource';
		$strings['Add Location'] = 'Add Location';
		$strings['Edit Location'] = 'Edit Location';
		$strings['Allowed'] = 'Allowed';
		$strings['Notify user'] = 'Notify user';
		$strings['User Reservations'] = 'User Reservations';
		$strings['Date'] = 'Date';
		$strings['User'] = 'User';
		$strings['Email Users'] = 'Email Users';
		$strings['Subject'] = 'Subject';
		$strings['Message'] = 'Message';
		$strings['Please select users'] = 'Please select users';
		$strings['Send Email'] = 'Send Email';
		$strings['problem sending email'] = 'Sorry, there was a problem sending your email. Please try again later.';
		$strings['The email sent successfully.'] = 'The email sent successfully.';
		$strings['do not refresh page'] = 'Please <u>do not</u> refresh this page. Doing so will send the email again.';
		$strings['Return to email management'] = 'Return to email management';
		$strings['Please select which tables and fields to export'] = 'Please select which tables and fields to export:';
		$strings['all fields'] = '- all fields -';
		$strings['HTML'] = 'HTML';
		$strings['Plain text'] = 'Plain text';
		$strings['XML'] = 'XML';
		$strings['CSV'] = 'CSV';
		$strings['Export Data'] = 'Export Data';
		$strings['Reset Password for'] = 'Reset Password for %s';
		$strings['Please edit your profile'] = 'Please edit your profile';
		$strings['Please register'] = 'Please register';
		$strings['Keep me logged in'] = 'Keep me logged in (requires cookies)';
		$strings['Edit Profile'] = 'Edit Profile';
		$strings['Register'] = 'Register';
		$strings['Please Log In'] = 'Please Log In';
		$strings['Email address'] = 'Email address';
		$strings['Password'] = 'Password';
		$strings['First time user'] = 'First time user?';
		$strings['Click here to register'] = 'Click here to register';
		$strings['Register for phpScheduleIt'] = 'Register for phpScheduleIt';
		$strings['Log In'] = 'Log In';
		$strings['View Schedule'] = 'View Schedule';
		$strings['View a read-only version of the schedule'] = 'View a read-only version of the schedule';
		$strings['I Forgot My Password'] = 'I Forgot My Password';
		$strings['Retreive lost password'] = 'Retreive lost password';
		$strings['Get online help'] = 'Get online help';
		$strings['Language'] = 'Language';
		$strings['(Default)'] = '(Default)';
		
		$strings['My Announcements'] = 'My Announcements';
		$strings['My Reservations'] = 'My Reservations';
		$strings['My Permissions'] = 'My Permissions';
		$strings['My Quick Links'] = 'My Quick Links';
		$strings['Announcements as of'] = 'Announcements as of %s';
		$strings['There are no announcements.'] = 'There are no announcements.';
		$strings['Resource'] = 'Resource';
		$strings['Created'] = 'Created';
		$strings['Last Modified'] = 'Last Modified';
		$strings['View this reservation'] = 'View this reservation';
		$strings['Modify this reservation'] = 'Modify this reservation';
		$strings['Delete this reservation'] = 'Delete this reservation';
		$strings['Bookings'] = 'Bookings';											// @since 1.2.0
		$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
		$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
		$strings['Mass Email Users'] = 'Mass Email Users';
		$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
		$strings['Export Database Content'] = 'Export Database Content';
		$strings['View System Stats'] = 'View System Stats';
		$strings['Email Administrator'] = 'Email Administrator';
		
		$strings['Email me when'] = 'Email me when:';
		$strings['I place a reservation'] = 'I place a reservation';
		$strings['My reservation is modified'] = 'My reservation is modified';
		$strings['My reservation is deleted'] = 'My reservation is deleted';
		$strings['I prefer'] = 'I prefer:';
		$strings['Your email preferences were successfully saved'] = 'Your email preferences were successfully saved!';
		$strings['Return to My Control Panel'] = 'Return to My Control Panel';
		
		$strings['Please select the starting and ending times'] = 'Please select the starting and ending times:';
		$strings['Please change the starting and ending times'] = 'Please change the starting and ending times:';
		$strings['Reserved time'] = 'Reserved time:';
		$strings['Minimum Reservation Length'] = 'Minimum Reservation Length:';
		$strings['Maximum Reservation Length'] = 'Maximum Reservation Length:';
		$strings['Reserved for'] = 'Reserved for:';
		$strings['Will be reserved for'] = 'Will be reserved for:';
		$strings['N/A'] = 'N/A';
		$strings['Update all recurring records in group'] = 'Update all recurring records in group?';
		$strings['Delete?'] = 'Delete?';
		$strings['Never'] = '-- Never --';
		$strings['Days'] = 'Days';
		$strings['Weeks'] = 'Weeks';
		$strings['Months (date)'] = 'Months (date)';
		$strings['Months (day)'] = 'Months (day)';
		$strings['First Days'] = 'First Days';
		$strings['Second Days'] = 'Second Days';
		$strings['Third Days'] = 'Third Days';
		$strings['Fourth Days'] = 'Fourth Days';
		$strings['Last Days'] = 'Last Days';
		$strings['Repeat every'] = 'Repeat every:';
		$strings['Repeat on'] = 'Repeat on:';
		$strings['Repeat until date'] = 'Repeat until date:';
		$strings['Choose Date'] = 'Choose Date';
		$strings['Summary'] = 'Summary';
		
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
		$strings['Resources'] = 'Resources';		// @since 1.2.0
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
		$strings['We could not find that logon in our database.'] = 'We could not find that logon in our database.';	// @since 1.1.0
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
		$strings['for the follwing dates'] = 'for the following dates:';
		$strings['Start time must be less than end time'] = 'Start time must be less than end time.';
		$strings['Current start time is'] = 'Current start time is:';
		$strings['Current end time is'] = 'Current end time is:';
		$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Reservation length does not fall within this resource\'s allowed length.';
		$strings['Your reservation is'] = 'Your reservation is:';
		$strings['Minimum reservation length'] = 'Minimum reservation length:';
		$strings['Maximum reservation length'] = 'Maximum reservation length:';
		$strings['You do not have permission to use this resource.'] = 'You do not have permission to use this resource.';
		$strings['reserved or unavailable'] = '%s to %s is reserved or unavailable.';	// @since 1.1.0
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
		    			. 'Your new password has been emailed to you.<br />'
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
		$strings['There is no way to undo this action'] = 'There is no way to undo this action!';
		$strings['Click to proceed'] = 'Click to proceed';
		$strings['Please delete this file.'] = 'Please delete this file.';
		$strings['Successful update'] = 'The update succeeded fully';
		$strings['Patch completed successfully'] = 'Patch completed successfully';
		
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
		$strings['Logon name'] = 'Username';
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
		$strings['Manage Additional Resources'] = 'Manage Accessories';
		$strings['Number Available'] = 'Number Available';
		$strings['Unlimited'] = 'Unlimited';
		$strings['Add Additional Resource'] = 'Add Accessory';
		$strings['Edit Additional Resource'] = 'Edit Accessory';
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
		
		// Since 2.0
		$strings['Login Error'] = 'We could not match your username or password';
		// end Since 2.0
		
		$this->Strings = $strings;
	}
	
	function _LoadEmails()
	{
		$email = array();
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
		
		$this->Emails = $email;
	}
	
	function _LoadDays()
	{
		$days = array();
		
		/***
		  DAY NAMES
		  All of these arrays MUST start with Sunday as the first element 
		   and go through the seven day week, ending on Saturday
		***/
		// The full day name
		$days['full'] = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		// The three letter abbreviation
		$days['abbr'] = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
		// The two letter abbreviation
		$days['two']  = array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');
		// The one letter abbreviation
		$days['letter'] = array('S', 'M', 'T', 'W', 'T', 'F', 'S');
		
		$this->Days = $days;
	}
	
	function _LoadMonths()
	{
		$months = array();
			
		/***
		  MONTH NAMES
		  All of these arrays MUST start with January as the first element
		   and go through the twelve months of the year, ending on December
		***/
		// The full month name
		$months['full'] = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		// The three letter month name
		$months['abbr'] = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

		$this->Months = $months;
	}
	
	function _LoadLetters()
	{
		$this->Letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	}
}
?>