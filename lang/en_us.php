<?php
require_once('Language.php');

class en_us extends Language
{
	public function __construct()
	{
		parent::__construct();
		$this->HtmlLang = 'en';
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
		$dates['general_date'] = 'm/d/Y';
		$dates['general_datetime'] = 'm/d/Y H:i:s';
		$dates['schedule_daily'] = 'l, m/d/Y';
		$dates['reservation_email'] = 'm/d/Y @ g:i A (e)';
		$dates['res_popup'] = 'm/d/Y g:i A';
		$dates['dashboard'] = 'l, m/d/Y g:i A';

		$this->Dates = $dates;
	}

	function _LoadStrings()
	{
		$strings = array();

		$strings['FirstName'] = 'First Name';
		$strings['LastName'] = 'Last Name';
		$strings['Timezone'] = 'Timezone';

		// new stuff
		$strings['Edit'] = 'Edit';
		$strings['Change'] = 'Change';
		$strings['Rename'] = 'Rename';
		$strings['Remove'] = 'Remove';
		$strings['Delete'] = 'Delete';
		$strings['Update'] = 'Update';
		$strings['Cancel'] = 'Cancel';
		$strings['Add'] = 'Add';
		$strings['Name'] = 'Name';
		$strings['Yes'] = 'Yes';
		$strings['No'] = 'No';
		$strings['FirstNameRequired'] = 'First name is required.';
		$strings['LastNameRequired'] = 'Last name is required.';
		$strings['PwMustMatch'] = 'Password confirmation must match password.';
		$strings['PwComplexity'] = 'Password must be at least 6 characters with a combination of letters, numbers and symbols.';
		$strings['ValidEmailRequired'] = 'A valid email address is required.';
		$strings['UniqueEmailRequired'] = 'That email address is already registered.';
		$strings['UniqueUsernameRequired'] = 'That user name is already registered.';
		$strings['UserNameRequired'] = 'User name is required.';
		$strings['Today'] = 'Today';
		$strings['BackToCalendar'] = 'Back to calendar';
		$strings['BeginDate'] = 'Begin';
		$strings['EndDate'] = 'End';
		$strings['Username'] = 'Username';
		$strings['Password'] = 'Password';
		$strings['PasswordConfirmation'] = 'Confirm Password';
		$strings['DefaultPage'] = 'Default Homepage';
		$strings['MyCalendar'] = 'My Calendar';
		$strings['ScheduleCalendar'] = 'Schedule Calendar';
		$strings['Registration'] = 'Registration';
		$strings['NoAnnouncements'] = 'There are no announcements';
		$strings['Announcements'] = 'Announcements';
		$strings['NoUpcomingReservations'] = 'You have no upcoming reservations';
		$strings['UpcomingReservations'] = 'Upcoming Reservations';
		$strings['ShowHide'] = 'Show/Hide';
		$strings['Error'] = 'Error';
		$strings['ReturnToPreviousPage'] = 'Return to the last page that you were on';
		$strings['UnknownError'] = 'Unknown Error';
		$strings['InsufficientPermissionsError'] = 'You do not have permission to access this resource';
		$strings['DoesNotRepeat'] = 'Does Not Repeat';
		$strings['Daily'] = 'Daily';
		$strings['Weekly'] = 'Weekly';
		$strings['Monthly'] = 'Monthly';
		$strings['Yearly'] = 'Yearly';
		$strings['RepeatPrompt'] = 'Repeat';
		$strings['days'] = 'days';
		$strings['weeks'] = 'weeks';
		$strings['months'] = 'months';
		$strings['years'] = 'years';
		$strings['day'] = 'day';
		$strings['week'] = 'week';
		$strings['month'] = 'month';
		$strings['year'] = 'year';
		$strings['repeatDayOfMonth'] = 'day of month';
		$strings['repeatDayOfWeek'] = 'day of week';
		$strings['RepeatUntilPrompt'] = 'Until';
		$strings['RepeatEveryPrompt'] = 'Every';
		$strings['RepeatDaysPrompt'] = 'On';
		$strings['CreateReservationHeading'] = 'Create a new reservation';
		$strings['EditReservationHeading'] = 'Editing reservation %s';
		$strings['ViewReservationHeading'] = 'Viewing reservation %s';
		$strings['ReservationErrors'] = 'Change Reservation';
		$strings['Create'] = 'Create';
		$strings['ThisInstance'] = 'Only This Instance';
		$strings['AllInstances'] = 'All Instances';
		$strings['FutureInstances'] = 'Future Instances';
		$strings['Print'] = 'Print';
		$strings['ShowHideNavigation'] = 'Show/Hide Navigation';
		$strings['ReferenceNumber'] = 'Reference Number';
		$strings['Tomorrow'] = 'Tomorrow';
		$strings['LaterThisWeek'] = 'Later This Week';
		$strings['NextWeek'] = 'Next Week';
		$strings['SignOut'] = 'Sign Out';
		$strings['LayoutDescription'] = 'Starts on %s, showing %s days at a time';
		$strings['AllResources'] = 'All Resources';
		$strings['TakeOffline'] = 'Take Offline';
		$strings['BringOnline'] = 'Bring Online';
		$strings['AddImage'] = 'Add Image';
		$strings['NoImage'] = 'No Image Assigned';
		$strings['Move'] = 'Move';
		$strings['AppearsOn'] = 'Appears On %s';
		$strings['Location'] = 'Location';
		$strings['NoLocationLabel'] = '(no location set)';
		$strings['Contact'] = 'Contact';
		$strings['NoContactLabel'] = '(no contact information)';
		$strings['Description'] = 'Description';
		$strings['NoDescriptionLabel'] = '(no description';
		$strings['Notes'] = 'Notes';
		$strings['NoNotesLabel'] = '(no notes)';
		$strings['UsageConfiguration'] = 'Usage Configuration';
		$strings['ChangeConfiguration'] = 'Change Configuration';
		$strings['ResourceMinLength'] = 'Reservations must last at least %s';
		$strings['ResourceMinLengthNone'] = 'There is no minimum reservation duration';
		$strings['ResourceMaxLength'] = 'Reservations cannot last more than %s';
		$strings['ResourceMaxLengthNone'] = 'There is no maximum reservation duration';
		$strings['ResourceRequiresApproval'] = 'Reservations must be approved';
		$strings['ResourceRequiresApprovalNone'] = 'Reservations do not require approval';
		$strings['ResourcePermissionAutoGranted'] = 'Permission is automatically granted';
		$strings['ResourcePermissionNotAutoGranted'] = 'Permission is automatically granted';
		$strings['ResourceMinNotice'] = 'Reservations must be made at least %s prior to start time';
		$strings['ResourceMinNoticeNone'] = 'Reservations can be made up until the current time';
		$strings['ResourceMaxNotice'] = 'Reservations must not end more than %s from the current time';
		$strings['ResourceMaxNoticeNone'] = 'Reservations can end at any point in the future';
		$strings['ResourceAllowMultiDay'] = 'Reservations can be made across days';
		$strings['ResourceNotAllowMultiDay'] = 'Reservations cannot be made across days';
		$strings['ResourceCapacity'] = 'This resource has a capacity of %s people';
		$strings['ResourceCapacityNone'] = 'This resource has unlimited capacity';
		$strings['AddNewResource'] = 'Add New Resource';
		$strings['AddNewUser'] = 'Add New User';
		$strings['AddUser'] = 'Add User';
		$strings['Schedule'] = 'Schedule';
		$strings['AddResource'] = 'Add Resource';
		$strings['Capacity'] = 'Capacity';
		$strings['Access'] = 'Access';
		$strings['Duration'] = 'Duration';
		$strings['Active'] = 'Active';
		$strings['Inactive'] = 'Inactive';
		$strings['ResetPassword'] = 'Reset Password';
		$strings['LastLogin'] = 'Last Login';
		$strings['Search'] = 'Search';
		$strings['ResourcePermissions'] = 'Resource Permissions';
		$strings['Reservations'] = 'Reservations';
		$strings['Groups'] = 'Groups';
		$strings['ResetPassword'] = 'Reset Password';
		$strings['AllUsers'] = 'All Users';
		$strings['AllGroups'] = 'All Groups';
		$strings['AllSchedules'] = 'All Schedules';
		$strings['UsernameOrEmail'] = 'Username or Email';
		$strings['Members'] = 'Members';
		$strings['QuickSlotCreation'] = 'Create slots every %s minutes between %s and %s';
		$strings['ApplyUpdatesTo'] = 'ApplyUpdatesTo';
		$strings['CancelParticipation'] = 'Cancel Participation';
		$strings['Attending'] = 'Attending';
		$strings['QuotaConfiguration'] = 'On %s for %s users in %s are limited to %s %s per %s';
		$strings['reservations'] = 'reservations';
		$strings['ChangeCalendar'] = 'Change Calendar';
		$strings['AddQuota'] = 'Add Quota';
		$strings['FindUser'] = 'Find User';
		$strings['Created'] = 'Created';
		$strings['LastModified'] = 'Last Modified';
		$strings['GroupName'] = 'Group Name';
		$strings['GroupMembers'] = 'Group Members';
		$strings['GroupRoles'] = 'Group Roles';
		$strings['GroupAdmin'] = 'Group Administrator';
		$strings['Actions'] = 'Actions';
		$strings['CurrentPassword'] = 'Current Password';
		$strings['NewPassword'] = 'New Password';
		$strings['InvalidPassword'] = 'Current password is incorrect';
		$strings['PasswordChangedSuccessfully'] = 'Your password has been changed successfully';
		$strings['SignedInAs'] = 'Signed in as';
		$strings['NotSignedIn'] = 'You are not signed in';
		$strings['ReservationTitle'] = 'Title of reservation';
		$strings['ReservationDescription'] = 'Description of reservation';
		$strings['ResourceList'] = 'Resources to be reserved';
		$strings['Accessories'] = 'Accessories';
		$strings['Add'] = 'Add';
		$strings['ParticipantList'] = 'Participants';
		$strings['InvitationList'] = 'Invitees';
		$strings['AccessoryName'] = 'Accessory Name';
		$strings['QuantityAvailable'] = 'Quantity Available';
		$strings['Resources'] = 'Resources';
		$strings['Participants'] = 'Participants';


		// Errors
		$strings['ReservationFailed'] = 'Your reservation could not be made';
		$strings['MinNoticeError'] = 'This reservation requires advance notice.  The earliest date that can be reserved is %s.';
		$strings['MaxNoticeError'] = 'This reservation cannot be made this far in the future.  The latest date that can be reserved is %s.';
		$strings['MinDurationError'] = 'This reservation must last at least %s.';
		$strings['MaxDurationError'] = 'This reservation cannot last longer than %s.';
		$strings['ConflictingAccessoryDates'] = 'There are not enough of the following accessories:';
		$strings['NoResourcePermission'] = 'You do not have permission to access one or more of the requested resources';
		$strings['ConflictingReservationDates'] = 'There are conflicting reservations on the following dates:';
		$strings['StartDateBeforeEndDateRule'] = 'The start date must be before the end date';
		$strings['StartIsInPast'] = 'The start date cannot be in the past';

		// Page Titles
		$strings['CreateReservation'] = 'Create Reservation';
		$strings['EditReservation'] = 'Editing Reservation';
		$strings['LogIn'] = 'Log In';
		$strings['ManageReservations'] = 'Manage Reservations';
		$strings['AwaitingActivation'] = 'Awaiting Activation';
		$strings['PendingApproval'] = 'Pending Approval';
		$strings['ManageSchedules'] = 'Manage Schedules';
		$strings['ManageResources'] = 'Manage Resources';
		$strings['ManageAccessories'] = 'Manage Accessories';
		$strings['ManageUsers'] = 'Manage Users';
		$strings['ManageGroups'] = 'Manage Groups';
		$strings['ManageQuotas'] = 'Manage Quotas';
		$strings['MyDashboard'] = 'My Dashboard';
		$strings['ServerSettings'] = 'Server Settings';
		$strings['Dashboard'] = 'Dashboard';
		$strings['Help'] = 'Help';
		$strings['Bookings'] = 'Bookings';
		$strings['Schedule'] = 'Schedule';
		$strings['Reservations'] = 'Reservations';
		$strings['Account'] = 'Account';
		$strings['EditProfile'] = 'Edit My Profile';
		$strings['FindAnOpening'] = 'Find An Opening';
		$strings['OpenInvitations'] = 'Open Invitations';
		$strings['MyCalendar'] = 'My Calendar';
		$strings['ResourceCalendar'] = 'Resource Calendar';
		$strings['Reservation'] = 'New Reservation';
		$strings['Install'] = 'Installation';
		$strings['ChangePassword'] = 'Change Password';
		//

		// Day representations
		$strings['DaySundaySingle'] = 'S';
		$strings['DayMondaySingle'] = 'M';
		$strings['DayTuesdaySingle'] = 'T';
		$strings['DayWednesdaySingle'] = 'W';
		$strings['DayThursdaySingle'] = 'T';
		$strings['DayFridaySingle'] = 'F';
		$strings['DaySaturdaySingle'] = 'S';

		$strings['DaySundayAbbr'] = 'Sun';
		$strings['DayMondayAbbr'] = 'Mon';
		$strings['DayTuesdayAbbr'] = 'Tue';
		$strings['DayWednesdayAbbr'] = 'Wed';
		$strings['DayThursdayAbbr'] = 'Thu';
		$strings['DayFridayAbbr'] = 'Fri';
		$strings['DaySaturdayAbbr'] = 'Sat';

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'Your Reservation Has Been Approved';
		$strings['ReservationCreatedSubject'] = 'Your Reservation Was Created';
		$strings['ReservationUpdatedSubject'] = 'Your Reservation Was Updated';
		$strings['ReservationCreatedAdminSubject'] = 'Notification: A Reservation Was Created';
		$strings['ReservationUpdatedAdminSubject'] = 'Notification: A Reservation Was Updated';
		$strings['ParticipantAddedSubject'] = 'Reservation Participation Notification';
		$strings['InviteeAddedSubject'] = 'Reservation Invitation';
		$strings['ResetPassword'] = 'Password Reset Request';
		$strings['ForgotPasswordEmailSent'] = 'An email has been sent to the address provided with instructions for resetting your password';
		//

		$this->Strings = $strings;
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
		$days['two'] = array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');
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
		$this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	}
}

?>