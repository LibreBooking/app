<?php
/**
 * Copyright 2017-2018 Nick Korbel
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
		// TODO: Implement GetReferenceNumber() method.
	}

	/**
	 * @param $additionalResourceIds int[]
	 */
	function SetAdditionalResources($additionalResourceIds)
	{
		// TODO: Implement SetAdditionalResources() method.
	}

	/**
	 * @param $title string
	 */
	function SetTitle($title)
	{
		// TODO: Implement SetTitle() method.
	}

	/**
	 * @param $description string
	 */
	function SetDescription($description)
	{
		// TODO: Implement SetDescription() method.
	}

	/**
	 * @param $repeatType string
	 */
	function SetRepeatType($repeatType)
	{
		// TODO: Implement SetRepeatType() method.
	}

	/**
	 * @param $repeatInterval string
	 */
	function SetRepeatInterval($repeatInterval)
	{
		// TODO: Implement SetRepeatInterval() method.
	}

	/**
	 * @param $repeatMonthlyType string
	 */
	function SetRepeatMonthlyType($repeatMonthlyType)
	{
		// TODO: Implement SetRepeatMonthlyType() method.
	}

	/**
	 * @param $repeatWeekdays int[]
	 */
	function SetRepeatWeekdays($repeatWeekdays)
	{
		// TODO: Implement SetRepeatWeekdays() method.
	}

	/**
	 * @param $referenceNumber string
	 */
	function SetReferenceNumber($referenceNumber)
	{
		// TODO: Implement SetReferenceNumber() method.
	}

	/**
	 * @param $reservationId int
	 */
	function SetReservationId($reservationId)
	{
		// TODO: Implement SetReservationId() method.
	}

	/**
	 * @param $seriesId int
	 */
	function SetSeriesId($seriesId)
	{
		// TODO: Implement SetSeriesId() method.
	}

	/**
	 * @param $isRecurring bool
	 */
	function SetIsRecurring($isRecurring)
	{
		// TODO: Implement SetIsRecurring() method.
	}

	/**
	 * @param $canBeEdited bool
	 */
	function SetIsEditable($canBeEdited)
	{
		// TODO: Implement SetIsEditable() method.
	}

	/**
	 * @param $canBeApproved bool
	 * @return void
	 */
	function SetIsApprovable($canBeApproved)
	{
		// TODO: Implement SetIsApprovable() method.
	}

	/**
	 * @param $amIParticipating
	 */
	function SetCurrentUserParticipating($amIParticipating)
	{
		// TODO: Implement SetCurrentUserParticipating() method.
	}

	/**
	 * @param $amIInvited
	 */
	function SetCurrentUserInvited($amIInvited)
	{
		// TODO: Implement SetCurrentUserInvited() method.
	}

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetStartReminder($reminderValue, $reminderInterval)
	{
		// TODO: Implement SetStartReminder() method.
	}

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetEndReminder($reminderValue, $reminderInterval)
	{
		// TODO: Implement SetEndReminder() method.
	}

	/**
	 * @param bool $canAlterParticipation
	 */
	public function SetCanAlterParticipation($canAlterParticipation)
	{
		// TODO: Implement SetCanAlterParticipation() method.
	}

	/**
	 * @param bool $isCheckInRequired
	 */
	public function SetCheckInRequired($isCheckInRequired)
	{
		$this->_CheckInRequired = $isCheckInRequired;
	}

	/**
	 * @param bool $isCheckOutRequired
	 */
	public function SetCheckOutRequired($isCheckOutRequired)
	{
		$this->_CheckOutRequired = $isCheckOutRequired;
	}

	/**
	 * @param int $autoReleaseMinutes
	 */
	public function SetAutoReleaseMinutes($autoReleaseMinutes)
	{
		$this->_AutoReleaseMinutes = $autoReleaseMinutes;
	}

	public function PageLoad()
	{
		// TODO: Implement PageLoad() method.
	}

	public function Redirect($url)
	{
		// TODO: Implement Redirect() method.
	}

	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
		// TODO: Implement RedirectToError() method.
	}

	public function IsPostBack()
	{
		// TODO: Implement IsPostBack() method.
	}

	public function IsValid()
	{
		// TODO: Implement IsValid() method.
	}

	public function GetLastPage()
	{
		// TODO: Implement GetLastPage() method.
	}

	public function RegisterValidator($validatorId, $validator)
	{
		// TODO: Implement RegisterValidator() method.
	}

	public function EnforceCSRFCheck()
	{
		// TODO: Implement EnforceCSRFCheck() method.
	}

	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param $startPeriods array|SchedulePeriod[]
	 * @param $endPeriods array|SchedulePeriod[]
	 */
	public function BindPeriods($startPeriods, $endPeriods)
	{
		// TODO: Implement BindPeriods() method.
	}

	/**
	 * Set the resources that can be reserved by this user
	 * @param $resources array|ResourceDto[]
	 */
	public function BindAvailableResources($resources)
	{
		// TODO: Implement BindAvailableResources() method.
	}

	/**
	 * @param $accessories Accessory[]
	 */
	public function BindAvailableAccessories($accessories)
	{
		// TODO: Implement BindAvailableAccessories() method.
	}

	/**
	 * @param $groups ResourceGroupTree
	 */
	public function BindResourceGroups($groups)
	{
		// TODO: Implement BindResourceGroups() method.
	}

	/**
	 * @param SchedulePeriod $selectedStart
	 * @param Date $startDate
	 */
	public function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate)
	{
		// TODO: Implement SetSelectedStart() method.
	}

	/**
	 * @param SchedulePeriod $selectedEnd
	 * @param Date $endDate
	 */
	public function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate)
	{
		// TODO: Implement SetSelectedEnd() method.
	}

	/**
	 * @param $repeatTerminationDate Date
	 */
	public function SetRepeatTerminationDate($repeatTerminationDate)
	{
		// TODO: Implement SetRepeatTerminationDate() method.
	}

	/**
	 * @param UserDto $user
	 */
	public function SetReservationUser(UserDto $user)
	{
		// TODO: Implement SetReservationUser() method.
	}

	/**
	 * @param IResource $resource
	 */
	public function SetReservationResource($resource)
	{
		// TODO: Implement SetReservationResource() method.
	}

	/**
	 * @param int $scheduleId
	 */
	public function SetScheduleId($scheduleId)
	{
		// TODO: Implement SetScheduleId() method.
	}

	/**
	 * @param ReservationUserView[] $participants
	 */
	public function SetParticipants($participants)
	{
		// TODO: Implement SetParticipants() method.
	}

	/**
	 * @param ReservationUserView[] $invitees
	 */
	public function SetInvitees($invitees)
	{
		// TODO: Implement SetInvitees() method.
	}

	/**
	 * @param $accessories ReservationAccessory[]|array
	 */
	public function SetAccessories($accessories)
	{
		// TODO: Implement SetAccessories() method.
	}

	/**
	 * @param $attachments ReservationAttachmentView[]|array
	 */
	public function SetAttachments($attachments)
	{
		// TODO: Implement SetAttachments() method.
	}

	/**
	 * @param $canChangeUser
	 */
	public function SetCanChangeUser($canChangeUser)
	{
		// TODO: Implement SetCanChangeUser() method.
	}

	/**
	 * @param bool $canShowAdditionalResources
	 */
	public function ShowAdditionalResources($canShowAdditionalResources)
	{
		// TODO: Implement ShowAdditionalResources() method.
	}

	/**
	 * @param bool $canShowUserDetails
	 */
	public function ShowUserDetails($canShowUserDetails)
	{
		// TODO: Implement ShowUserDetails() method.
	}

	/**
	 * @param bool $shouldShow
	 */
	public function SetShowParticipation($shouldShow)
	{
		// TODO: Implement SetShowParticipation() method.
	}

	/**
	 * @param bool $showReservationDetails
	 */
	public function ShowReservationDetails($showReservationDetails)
	{
		// TODO: Implement ShowReservationDetails() method.
	}

	/**
	 * @param bool $isHidden
	 */
	public function HideRecurrence($isHidden)
	{
		// TODO: Implement HideRecurrence() method.
	}

	/**
	 * @param bool $allowParticipation
	 */
	function SetAllowParticipantsToJoin($allowParticipation)
	{
		// TODO: Implement SetAllowParticipantsToJoin() method.
	}

	/**
	 * @param string[] $participatingGuests
	 */
	public function SetParticipatingGuests($participatingGuests)
	{
		// TODO: Implement SetParticipatingGuests() method.
	}

	/**
	 * @param string[] $invitedGuests
	 */
	public function SetInvitedGuests($invitedGuests)
	{
		// TODO: Implement SetInvitedGuests() method.
	}

	/**
	 * @param bool $requiresApproval
	 */
	public function SetRequiresApproval($requiresApproval)
	{
		// TODO: Implement SetRequiresApproval() method.
	}
}