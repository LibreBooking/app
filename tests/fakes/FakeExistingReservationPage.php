<?php
/**
 * Copyright 2017-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Reservation/ExistingReservationPage.php');

class FakeExistingReservationPage extends FakePageBase implements IExistingReservationPage
{
	public $_CheckInRequired = false;
	public $_CheckOutRequired = false;
	public $_AutoReleaseMinutes = null;

	function GetReferenceNumber()
	{
	}

	function SetAdditionalResources($additionalResourceIds)
	{
	}

	function SetTitle($title)
	{
	}

	function SetDescription($description)
	{
	}

	function SetRepeatType($repeatType)
	{
	}

	function SetRepeatInterval($repeatInterval)
	{
	}

	function SetRepeatMonthlyType($repeatMonthlyType)
	{
	}

	function SetRepeatWeekdays($repeatWeekdays)
	{
	}

	function SetReferenceNumber($referenceNumber)
	{
	}

	function SetReservationId($reservationId)
	{
	}

	function SetSeriesId($seriesId)
	{
	}

	function SetIsRecurring($isRecurring)
	{
	}

	function SetIsEditable($canBeEdited)
	{
	}

	function SetIsApprovable($canBeApproved)
	{
	}

	function SetCurrentUserParticipating($amIParticipating)
	{
	}

	function SetCurrentUserInvited($amIInvited)
	{
	}

	public function SetStartReminder($reminderValue, $reminderInterval)
	{
	}

	public function SetEndReminder($reminderValue, $reminderInterval)
	{
	}

	public function SetCanAlterParticipation($canAlterParticipation)
	{
	}

	public function SetCheckInRequired($isCheckInRequired)
	{
		$this->_CheckInRequired = $isCheckInRequired;
	}

	public function SetCheckOutRequired($isCheckOutRequired)
	{
		$this->_CheckOutRequired = $isCheckOutRequired;
	}

	public function SetAutoReleaseMinutes($autoReleaseMinutes)
	{
		$this->_AutoReleaseMinutes = $autoReleaseMinutes;
	}

	public function PageLoad()
	{
	}

	public function Redirect($url)
	{
	}

	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
	}

	public function IsPostBack()
	{
	}

	public function IsValid()
	{
	}

	public function GetLastPage($defaultPage = '')
	{
	}

	public function RegisterValidator($validatorId, $validator)
	{
	}

	public function EnforceCSRFCheck()
	{
	}

	public function BindPeriods($startPeriods, $endPeriods, $lockPeriods)
	{
	}

	public function BindAvailableResources($resources)
	{
	}

	public function BindAvailableAccessories($accessories)
	{
	}

	public function BindResourceGroups($groups)
	{
	}

	public function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate)
	{
	}

	public function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate)
	{
	}

	public function SetRepeatTerminationDate($repeatTerminationDate)
	{
	}

	public function SetReservationUser(UserDto $user)
	{
	}

	public function SetReservationResource($resource)
	{
	}

	public function SetScheduleId($scheduleId)
	{
	}

	public function SetParticipants($participants)
	{
	}

	public function SetInvitees($invitees)
	{
	}

	public function SetAccessories($accessories)
	{
	}

	public function SetAttachments($attachments)
	{
	}

	public function SetCanChangeUser($canChangeUser)
	{
	}

	public function ShowAdditionalResources($canShowAdditionalResources)
	{
	}

	public function ShowUserDetails($canShowUserDetails)
	{
	}

	public function SetShowParticipation($shouldShow)
	{
	}

	public function ShowReservationDetails($showReservationDetails)
	{
	}

	public function HideRecurrence($isHidden)
	{
	}

	function SetAllowParticipantsToJoin($allowParticipation)
	{
	}

	public function SetParticipatingGuests($participatingGuests)
	{
	}

	public function SetInvitedGuests($invitedGuests)
	{
	}

	public function SetRequiresApproval($requiresApproval)
	{
	}

    public function SetAvailability(DateRange $availability)
    {
    }

    public function SetFirstWeekday($weekday)
    {
    }

    public function MakeUnavailable()
    {
        // TODO: Implement MakeUnavailable() method.
    }

    public function IsUnavailable()
    {
        // TODO: Implement IsUnavailable() method.
    }

    public function SetTerms($termsOfService)
    {
        // TODO: Implement SetTerms() method.
    }

    public function SetTermsAccepted($accepted)
    {
        // TODO: Implement SetTermsAccepted() method.
    }

    public function SetCustomRepeatDates($customRepeatDates)
    {
        // TODO: Implement SetCustomRepeatDates() method.
    }

	public function SetMaximumResources($maximum)
	{
		// TODO: Implement SetMaximumResources() method.
	}
}