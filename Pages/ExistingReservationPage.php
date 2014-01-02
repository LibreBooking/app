<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/ReservationPage.php');

interface IExistingReservationPage extends IReservationPage
{
	function GetReferenceNumber();

	/**
	 * @param $additionalResourceIds int[]
	 */
	function SetAdditionalResources($additionalResourceIds);

	/**
	 * @param $title string
	 */
	function SetTitle($title);

	/**
	 * @param $description string
	 */
	function SetDescription($description);

	/**
	 * @param $repeatType string
	 */
	function SetRepeatType($repeatType);

	/**
	 * @param $repeatInterval string
	 */
	function SetRepeatInterval($repeatInterval);

	/**
	 * @param $repeatMonthlyType string
	 */
	function SetRepeatMonthlyType($repeatMonthlyType);

	/**
	 * @param $repeatWeekdays int[]
	 */
	function SetRepeatWeekdays($repeatWeekdays);

	/**
	 * @param $referenceNumber string
	 */
	function SetReferenceNumber($referenceNumber);

	/**
	 * @param $reservationId int
	 */
	function SetReservationId($reservationId);

	/**
	 * @param $isRecurring bool
	 */
	function SetIsRecurring($isRecurring);

	/**
	 * @param $canBeEdited bool
	 */
	function SetIsEditable($canBeEdited);

	/**
	 * @abstract
	 * @param $canBeApproved bool
	 * @return void
	 */
	function SetIsApprovable($canBeApproved);

	/**
	 * @param $amIParticipating
	 */
	function SetCurrentUserParticipating($amIParticipating);

	/**
	 * @param $amIInvited
	 */
	function SetCurrentUserInvited($amIInvited);

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetStartReminder($reminderValue, $reminderInterval);

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetEndReminder($reminderValue, $reminderInterval);
}

class ExistingReservationPage extends ReservationPage implements IExistingReservationPage
{
	protected $IsEditable = false;
	protected $IsApprovable = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function PageLoad()
	{
		parent::PageLoad();
	}

	protected function GetPresenter()
	{
		$preconditionService = new EditReservationPreconditionService($this->permissionServiceFactory);
		$reservationViewRepository = new ReservationViewRepository();

		return new EditReservationPresenter($this,
											$this->initializationFactory,
											$preconditionService,
											$reservationViewRepository);
	}

	protected function GetTemplateName()
	{
		if ($this->IsApprovable)
		{
			return 'Reservation/approve.tpl';
		}
		if ($this->IsEditable)
		{
			return 'Reservation/edit.tpl';
		}
		return 'Reservation/view.tpl';
	}

	protected function GetReservationAction()
	{
		return ReservationAction::Update;
	}

	public function GetReferenceNumber()
	{
		return $this->server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function SetAdditionalResources($additionalResourceIds)
	{
		$this->Set('AdditionalResourceIds', $additionalResourceIds);
	}

	public function SetTitle($title)
	{
		$this->Set('ReservationTitle', $title);
	}

	public function SetDescription($description)
	{
		$this->Set('Description', $description);
	}

	public function SetRepeatType($repeatType)
	{
		$this->Set('RepeatType', $repeatType);
	}

	public function SetRepeatInterval($repeatInterval)
	{
		$this->Set('RepeatInterval', $repeatInterval);
	}

	public function SetRepeatMonthlyType($repeatMonthlyType)
	{
		$this->Set('RepeatMonthlyType', $repeatMonthlyType);
	}

	public function SetRepeatWeekdays($repeatWeekdays)
	{
		$this->Set('RepeatWeekdays', $repeatWeekdays);
	}

	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}

	public function SetReservationId($reservationId)
	{
		$this->Set('ReservationId', $reservationId);
	}

	public function SetIsRecurring($isRecurring)
	{
		$this->Set('IsRecurring', $isRecurring);
	}

	public function SetIsEditable($canBeEdited)
	{
		$this->IsEditable = $canBeEdited;
	}

	/**
	 * @param $amIParticipating
	 */
	public function SetCurrentUserParticipating($amIParticipating)
	{
		$this->Set('IAmParticipating', $amIParticipating);
	}

	/**
	 * @param $amIInvited
	 */
	public function SetCurrentUserInvited($amIInvited)
	{
		$this->Set('IAmInvited', $amIInvited);
	}

	/**
	 * @param $canBeApproved bool
	 * @return void
	 */
	public function SetIsApprovable($canBeApproved)
	{
		$this->IsApprovable = $canBeApproved;
	}

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetStartReminder($reminderValue, $reminderInterval)
	{
		$this->Set('ReminderTimeStart', $reminderValue);
		$this->Set('ReminderIntervalStart', $reminderInterval);
	}

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetEndReminder($reminderValue, $reminderInterval)
	{
		$this->Set('ReminderTimeEnd', $reminderValue);
		$this->Set('ReminderIntervalEnd', $reminderInterval);
	}
}

?>