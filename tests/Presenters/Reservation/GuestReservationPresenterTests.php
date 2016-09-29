<?php

/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Reservation/GuestReservationPresenter.php');

class GuestReservationPresenterTests extends TestBase
{
	/**
	 * @var FakeGuestReservationPage
	 */
	private $page;
	/**
	 * @var GuestReservationPresenter
	 */
	private $presenter;

	/**
	 * @var IReservationInitializerFactory
	 */
	private $factory;

	/**
	 * @var INewReservationPreconditionService
	 */
	private $preconditionService;
	/**
	 * @var FakeRegistration
	 */
	private $registration;
	/**
	 * @var IReservationInitializer
	 */
	private $initializer;
	/**
	 * @var FakeWebAuthentication
	 */
	private $authentication;

	public function setup()
	{
		$this->page = new FakeGuestReservationPage();
		$this->registration = new FakeRegistration();
		$this->factory = $this->getMock('IReservationInitializerFactory');
		$this->preconditionService = $this->getMock('INewReservationPreconditionService');
		$this->initializer = $this->getMock('IReservationInitializer');
		$this->authentication = new FakeWebAuthentication();

		$this->factory->expects($this->any())
					->method('GetNewInitializer')
					->with($this->anything())
					->will($this->returnValue($this->initializer));

		$this->presenter = new GuestReservationPresenter($this->page,
														 $this->registration,
														 $this->authentication,
														 $this->factory,
														 $this->preconditionService);
		parent::setup();
	}

	public function testRegistersAGuestAccount()
	{
		$this->page->_GuestInformationCollected = false;
		$this->page->_Email = 'email@address.com';
		$this->page->_CreatingAccount = true;

		$this->initializer->expects($this->once())
					->method('Initialize');

		$this->presenter->PageLoad();

		$this->assertEquals($this->page->_Email, $this->registration->_Email);
		$this->assertTrue($this->registration->_RegisterCalled);
		$this->assertEquals($this->authentication->_LastLogin, $this->page->_Email);
	}

	public function testPermissionStrategyAddsPermissionForAllScheduleResources()
	{
		$this->page->_ScheduleId = 455;
		$strategy = new GuestReservationPermissionStrategy($this->page);

		$user = new FakeUser(123);

		$strategy->AddAccount($user);

		$this->assertTrue($this->db->ContainsCommand(new AutoAssignGuestPermissionsCommand($user->Id(), $this->page->_ScheduleId)));
	}
}

class FakeGuestReservationPage implements IGuestReservationPage
{
	public $_GuestInformationCollected = false;
	public $_Email;
	public $_CreatingAccount = false;
	public $_ScheduleId;

	public function GuestInformationCollected()
	{
		return $this->_GuestInformationCollected;
	}

	public function GetEmail()
	{
		return $this->_Email;
	}

	public function IsCreatingAccount()
	{
		return $this->_CreatingAccount;
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
		return true;
	}

	public function IsValid()
	{
		return true;
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

	public function GetRequestedResourceId()
	{
		// TODO: Implement GetRequestedResourceId() method.
	}

	public function GetRequestedScheduleId()
	{
		return $this->_ScheduleId;
	}

	/**
	 * @return Date
	 */
	public function GetReservationDate()
	{
		// TODO: Implement GetReservationDate() method.
	}

	/**
	 * @return Date
	 */
	public function GetStartDate()
	{
		// TODO: Implement GetStartDate() method.
	}

	/**
	 * @return Date
	 */
	public function GetEndDate()
	{
		// TODO: Implement GetEndDate() method.
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

    public function GetSortField()
    {
        // TODO: Implement GetSortField() method.
    }

    public function GetSortDirection()
    {
        // TODO: Implement GetSortDirection() method.
    }
}
