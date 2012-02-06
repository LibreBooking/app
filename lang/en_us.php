<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('Language.php');

class en_us extends Language
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _LoadDates()
    {
        $dates = array();

        $dates['general_date'] = 'm/d/Y';
        $dates['general_datetime'] = 'm/d/Y H:i:s';
        $dates['schedule_daily'] = 'l, m/d/Y';
        $dates['reservation_email'] = 'm/d/Y @ g:i A (e)';
        $dates['res_popup'] = 'm/d/Y g:i A';
        $dates['dashboard'] = 'l, m/d/Y g:i A';
        $dates['period_time'] = "g:i A";
        $this->Dates['general_date_js'] = "mm/dd/yy";;

        $this->Dates = $dates;
    }

    protected function _LoadStrings()
    {
        $strings = array();

        $strings['FirstName'] = 'First Name';
        $strings['LastName'] = 'Last Name';
        $strings['Timezone'] = 'Timezone';
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
        $strings['CaptchaMustMatch'] = 'Please enter the letters from security image exactly as shown.';
        $strings['Today'] = 'Today';
        $strings['Week'] = 'Week';
        $strings['Month'] = 'Month';
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
        $strings['MissingReservationResourceError'] = 'A resource was not selected';
        $strings['MissingReservationScheduleError'] = 'A schedule was not selected';
        $strings['DoesNotRepeat'] = 'Does Not Repeat';
        $strings['Daily'] = 'Daily';
        $strings['Weekly'] = 'Weekly';
        $strings['Monthly'] = 'Monthly';
        $strings['Yearly'] = 'Yearly';
        $strings['RepeatPrompt'] = 'Repeat';
        $strings['hours'] = 'hours';
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
        $strings['NoDescriptionLabel'] = '(no description)';
        $strings['Notes'] = 'Notes';
        $strings['NoNotesLabel'] = '(no notes)';
        $strings['NoTitleLabel'] = '(no title)';
        $strings['UsageConfiguration'] = 'Usage Configuration';
        $strings['ChangeConfiguration'] = 'Change Configuration';
        $strings['ResourceMinLength'] = 'Reservations must last at least %s';
        $strings['ResourceMinLengthNone'] = 'There is no minimum reservation duration';
        $strings['ResourceMaxLength'] = 'Reservations cannot last more than %s';
        $strings['ResourceMaxLengthNone'] = 'There is no maximum reservation duration';
        $strings['ResourceRequiresApproval'] = 'Reservations must be approved';
        $strings['ResourceRequiresApprovalNone'] = 'Reservations do not require approval';
        $strings['ResourcePermissionAutoGranted'] = 'Permission is automatically granted';
        $strings['ResourcePermissionNotAutoGranted'] = 'Permission is not automatically granted';
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
        $strings['User'] = 'User';
        $strings['Resource'] = 'Resource';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Approve';
        $strings['Page'] = 'Page';
        $strings['Rows'] = 'Rows';
        $strings['Unlimited'] = 'Unlimited';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Email Address';
        $strings['Phone'] = 'Phone';
        $strings['Organization'] = 'Organization';
        $strings['Position'] = 'Position';
        $strings['Language'] = 'Language';
        $strings['Permissions'] = 'Permissions';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'Find Group';
        $strings['Manage'] = 'Manage';
        $strings['None'] = 'None';
        $strings['AddToOutlook'] = 'Add to Outlook';
        $strings['Done'] = 'Done';
        $strings['RememberMe'] = 'Remember Me';
        $strings['FirstTimeUser?'] = 'First Time User?';
        $strings['CreateAnAccount'] = 'Create an Account';
        $strings['ViewSchedule'] = 'View Schedule';
        $strings['ForgotMyPassword'] = 'I Forgot My Password';
        $strings['YouWillBeEmailedANewPassword'] = 'You will be emailed a new randomly generated password';
        $strings['Close'] = 'Close';
        $strings['ExportToCSV'] = 'Export to CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Working';
        $strings['Login'] = 'Login';
        $strings['AdditionalInformation'] = 'Additional Information';
        $strings['AllFieldsAreRequired'] = 'all fields are required';
        $strings['Optional'] = 'optional';
        $strings['YourProfileWasUpdated'] = 'Your profile was updated';
        $strings['YourSettingsWereUpdated'] = 'Your settings were updated';
        $strings['Register'] = 'Register';
        $strings['SecurityCode'] = 'Security Code';
        $strings['ReservationCreatedPreference'] = 'When I create a reservation or a reservation is created on my behalf';
        $strings['ReservationUpdatedPreference'] = 'When I update a reservation or a reservation is updated on my behalf';
        $strings['ReservationApprovalPreference'] = 'When my pending reservation is approved';
        $strings['PreferenceSendEmail'] = 'Send me an email';
        $strings['PreferenceNoEmail'] = 'Do not notify me';
        $strings['ReservationCreated'] = 'Your reservation was successfully created!';
        $strings['ReservationUpdated'] = 'Your reservation was successfully updated!';
        $strings['ReservationRemoved'] = 'Your reservation was removed';
        $strings['YourReferenceNumber'] = 'Your reference number is %s';
        $strings['UpdatingReservation'] = 'Updating reservation';
        $strings['ChangeUser'] = 'Change User';
        $strings['MoreResources'] = 'More Resources';
        $strings['ReservationLength'] = 'Reservation Length';
        $strings['ParticipantList'] = 'Participant List';
        $strings['AddParticipants'] = 'Add Participants';
        $strings['InviteOthers'] = 'Invite Others';
        $strings['AddResources'] = 'Add Resources';
        $strings['AddAccessories'] = 'Add Accessories';
        $strings['Accessory'] = 'Accessory';
        $strings['QuantityRequested'] = 'Quantity Requested';
        $strings['CreatingReservation'] = 'Creating Reservation';
        $strings['UpdatingReservation'] = 'Updating Reservation';
        $strings['DeleteWarning'] = 'This action is permanent and irrecoverable!';
        $strings['DeleteAccessoryWarning'] = 'Deleting this accessory will remove it from all reservations.';
        $strings['AddAccessory'] = 'Add Accessory';
        $strings['AddBlackout'] = 'Add Blackout';
        $strings['AllResourcesOn'] = 'All Resources On';
        $strings['Reason'] = 'Reason';
        $strings['BlackoutShowMe'] = 'Show me conflicting reservations';
        $strings['BlackoutDeleteConflicts'] = 'Delete conflicting reservations';
        $strings['Filter'] = 'Filter';
        $strings['Between'] = 'Between';
        $strings['CreatedBy'] = 'Created By';
        $strings['BlackoutCreated'] = 'Blackout Created!';
        $strings['BlackoutNotCreated'] = 'Blackout could not be created!';
        $strings['BlackoutConflicts'] = 'There are conflicting blackout times';
        $strings['ReservationConflicts'] = 'There are conflicting reservations times';
        $strings['UsersInGroup'] = 'Users in this group';
        $strings['Browse'] = 'Browse';
        $strings['DeleteGroupWarning'] = 'Deleting this group will remove all associated resource permissions.  Users in this group may lose access to resources.';
        $strings['WhatRolesApplyToThisGroup'] = 'What roles apply to this group?';
        $strings['WhoCanManageThisGroup'] = 'Who can manage this group?';
        $strings['AddGroup'] = 'Add Group';
        $strings['AllQuotas'] = 'All Quotas';
        $strings['QuotaReminder'] = 'Remember: Quotas are enforced based on the schedule\'s timezone.';
        $strings['AllReservations'] = 'All Reservations';
        $strings['PendingReservations'] = 'Pending Reservations';
        $strings['Approving'] = 'Approving';
        $strings['MoveToSchedule'] = 'Move to schedule';
        $strings['DeleteResourceWarning'] = 'Deleting this resource will delete all associated data, including';
        $strings['DeleteResourceWarningReservations'] = 'all past, current and future reservations associated with it';
        $strings['DeleteResourceWarningPermissions'] = 'all permission assignments';
        $strings['DeleteResourceWarningReassign'] = 'Please reassign anything that you do not want to be deleted before proceeding';
        $strings['ScheduleLayout'] = 'Layout (all times %s)';
        $strings['ReservableTimeSlots'] = 'Reservable Time Slots';
        $strings['BlockedTimeSlots'] = 'Blocked Time Slots';
        $strings['ThisIsTheDefaultSchedule'] = 'This is the default schedule';
        $strings['DefaultScheduleCannotBeBroughtDown'] = 'Default schedule cannot be brought down';
        $strings['MakeDefault'] = 'Make Default';
        $strings['BringDown'] = 'Bring Down';
        $strings['ChangeLayout'] = 'Change Layout';
        $strings['AddSchedule'] = 'Add Schedule';
        $strings['StartsOn'] = 'Starts On';
        $strings['NumberOfDaysVisible'] = 'Number of Days Visible';
        $strings['UseSameLayoutAs'] = 'Use Same Layout As';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Optional Label';
        $strings['LayoutInstructions'] = 'Enter one slot per line.  Slots must be provided for all 24 hours of the day beginning and ending at 12:00 AM.';
        $strings['AddUser'] = 'Add User';
        $strings['UserPermissionInfo'] = 'Actual access to resource may be different depending on user role, group permissions, or external permission settings';
        $strings['DeleteUserWarning'] = 'Deleting this user will remove all of their current, future, and historical reservations.';
        $strings['AddAnnouncement'] = 'Add Announcement';
        $strings['Announcement'] = 'Announcement';
        $strings['Priority'] = 'Priority';
        $strings['Reservable'] = 'Reservable';
        $strings['Unreservable'] = 'Unreservable';
        $strings['Reserved'] = 'Reserved';
        $strings['MyReservation'] = 'My Reservation';
        $strings['Pending'] = 'Pending';
        $strings['Past'] = 'Past';
        $strings['Restricted'] = 'Restricted';
        $strings['ViewAll'] = 'View All';

        // Errors
        $strings['LoginError'] = 'We could not match your username or password';
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
        $strings['EmailDisabled'] = 'The administrator has disabled email notifications';
        $strings['ValidLayoutRequired'] = 'Slots must be provided for all 24 hours of the day beginning and ending at 12:00 AM.';

        // Page Titles
        $strings['CreateReservation'] = 'Create Reservation';
        $strings['EditReservation'] = 'Editing Reservation';
        $strings['LogIn'] = 'Log In';
        $strings['ManageReservations'] = 'Reservations';
        $strings['AwaitingActivation'] = 'Awaiting Activation';
        $strings['PendingApproval'] = 'Pending Approval';
        $strings['ManageSchedules'] = 'Schedules';
        $strings['ManageResources'] = 'Resources';
        $strings['ManageAccessories'] = 'Accessories';
        $strings['ManageUsers'] = 'Users';
        $strings['ManageGroups'] = 'Groups';
        $strings['ManageQuotas'] = 'Quotas';
        $strings['ManageBlackouts'] = 'Blackout Times';
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
        $strings['MyAccount'] = 'My Account';
        $strings['Profile'] = 'Profile';
        $strings['ApplicationManagement'] = 'Application Management';
        $strings['ForgotPassword'] = 'Forgot Password';
        $strings['NotificationPreferences'] = 'Notification Preferences';
        $strings['ManageAnnouncements'] = 'Announcements';
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

    protected function _LoadDays()
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

    protected function _LoadMonths()
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

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
        return 'en';
    }
}

?>