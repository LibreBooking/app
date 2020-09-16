<?php
/**
 * Copyright 2011-2020 Nick Korbel
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

class ReservationAuthorizationTests extends TestBase
{
	/**
	 * @var FakeAuthorizationService
	 */
	private $authorizationService;

	/**
	 * @var FakeUserSession
	 */
	private $currentUser;

	/**
	 * @var FakeUserSession
	 */
	private $adminUser;

	/**
	 * @var ReservationAuthorization
	 */
	private $reservationAuthorization;

	public function setUp(): void
	{
		parent::setup();

		$this->authorizationService = new FakeAuthorizationService();

		$this->currentUser = new FakeUserSession(false, null, 998);
		$this->adminUser = new FakeUserSession(true, null, 999);

		$this->reservationAuthorization = new ReservationAuthorization($this->authorizationService);
	}

	public function testCanEditIfTheCurrentUserIsTheOwnerIfReservationHasNotBegun()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::FUTURE);
		$futureDate = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->StartDate = $futureDate;
		$reservationView->EndDate = $futureDate->AddDays(1);

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertTrue($isEditable);
	}

	public function testCanEditIfTheCurrentUserIsTheOwnerIfReservationHasNotEnded()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::CURRENT);
		$future = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->EndDate = $future;
		$reservationView->StartDate = Date::Now()->AddDays(-1);

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertTrue($isEditable);
	}

	public function testCanEditIfTheCurrentUserIsTheOwnerAndThereIsNoConstraint()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::NONE);
		$past = Date::Now()->AddDays(-11);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->EndDate = $past;
		$reservationView->StartDate = $past->AddDays(-1);

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertTrue($isEditable);
	}

	public function testIsNotEditableIfReservationHasBegunAndCurrentUserIsNotAdmin()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::FUTURE);
		$past = Date::Now()->AddDays(-1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->StartDate = $past;
		$reservationView->EndDate = Date::Now()->AddDays(2);

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertFalse($isEditable);
	}

	public function testIsNotEditableIfReservationHasEndedAndCurrentUserIsNotAdmin()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::CURRENT);
		$past = Date::Now()->AddDays(-1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->EndDate = $past;
		$reservationView->StartDate	= $past->AddDays(-1);

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertFalse($isEditable);
	}

	public function testIsNotEditableIfCurrentUserIsNotTheOwnerAndNotAuthorized()
	{
		$endsInFuture = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$ownerId = 92929;
		$reservationView->OwnerId = $ownerId;
		$reservationView->EndDate = Date::Now()->AddDays(-1);
		$reservationView->EndDate = $endsInFuture;

		$this->authorizationService->_CanReserveFor = false;

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertFalse($isEditable);
	}

	public function testCanEditPastReservationIfCurrentUserIsAdmin()
	{
		$endsInPast = Date::Now()->AddDays(-1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = 92929;
		$reservationView->StartDate = $endsInPast->AddDays(-1);
		$reservationView->EndDate = $endsInPast;

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->adminUser);

		$this->assertTrue($isEditable);
	}

	public function testIsEditableIfCurrentUserIsAuthorized()
	{
		$endsInFuture = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$ownerId = 92929;
		$reservationView->OwnerId = $ownerId;
		$reservationView->EndDate = $endsInFuture;
		$reservationView->StartDate = Date::Now()->AddDays(-1);

		$this->authorizationService->_CanReserveFor = true;

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertTrue($isEditable);
	}

	public function testIsEditableIfCurrentUserIsAuthorizedForAtLeastOneResource()
	{
		$endsInFuture = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$ownerId = 92929;
		$reservationView->OwnerId = $ownerId;
		$reservationView->EndDate = $endsInFuture;
		$reservationView->StartDate = Date::Now()->AddDays(-1);
		$resource1 = new ReservationResourceView(1, '', 1, 1, 1, ResourceStatus::AVAILABLE, false, null);
		$reservationView->Resources = array($resource1);

		$this->authorizationService->_CanReserveFor = false;
		$this->authorizationService->_CanEditForResource = true;

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertTrue($isEditable);
	}

	public function testCanBeApprovedIfCurrentUserIsAuthorizedForAtLeastOneResource()
	{
		$endsInFuture = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$ownerId = 92929;
		$reservationView->OwnerId = $ownerId;
		$reservationView->StartDate = Date::Now()->AddDays(-1);
		$reservationView->EndDate = $endsInFuture;
		$reservationView->StatusId = ReservationStatus::Pending;
		$resource1 = new ReservationResourceView(1, '', 1, 1, 1, ResourceStatus::AVAILABLE, false, null);
		$reservationView->Resources = array($resource1);

		$this->authorizationService->_CanApproveFor = false;
		$this->authorizationService->_CanApproveForResource = true;

		$canBeApproved = $this->reservationAuthorization->CanApprove($reservationView, $this->currentUser);

		$this->assertTrue($canBeApproved);
	}

	public function testCanChangeUsersIfTheCurrentUserIsAnAdmin()
	{
		$this->authorizationService->_CanReserveForOthers = false;

		$asAdmin = $this->reservationAuthorization->CanChangeUsers($this->adminUser);

		$this->assertTrue($asAdmin);
	}

	public function testCanChangeUsersIfTheCurrentUserIsAuthorized()
	{
		$authorizedUser = new FakeUserSession();

		$this->authorizationService->_CanReserveForOthers = true;

		$asAuthorized = $this->reservationAuthorization->CanChangeUsers($authorizedUser);

		$this->assertTrue($asAuthorized);
	}

	public function testCanApprovePendingReservationsIfTheCurrentUserIsAnAdmin()
	{
		$reservationOwnerId = 123;

		$this->authorizationService->_CanApproveFor = false;

		$pendingReservation = new ReservationView();
		$pendingReservation->StatusId = ReservationStatus::Pending;
		$pendingReservation->OwnerId = $reservationOwnerId;

		$asAdmin = $this->reservationAuthorization->CanApprove($pendingReservation, $this->adminUser);

		$this->assertTrue($asAdmin);
	}

	public function testCanApprovePendingReservationsIfTheCurrentUserIsAuthorized()
	{
		$authorizedUser = new FakeUserSession();
		$reservationOwnerId = 123;

		$this->authorizationService->_CanApproveFor = true;

		$pendingReservation = new ReservationView();
		$pendingReservation->StatusId = ReservationStatus::Pending;
		$pendingReservation->OwnerId = $reservationOwnerId;

		$asAuthorized = $this->reservationAuthorization->CanApprove($pendingReservation, $authorizedUser);

		$this->assertTrue($asAuthorized);
	}

	public function testCanNotApproveReservationsThatDoNotRequireApproval()
	{
		$approvedReservation = new ReservationView();
		$approvedReservation->StatusId = ReservationStatus::Created;

		$canApprove = $this->reservationAuthorization->CanApprove($approvedReservation, $this->adminUser);

		$this->assertFalse($canApprove);
	}

	public function testCanSeeDetailsIfCanBeReserved()
	{
		$reservationView = new ReservationView();
		$ownerId = 92929;
		$reservationView->OwnerId = $ownerId;
		$resource1 = new ReservationResourceView(1, '', 1, 1, 1, ResourceStatus::AVAILABLE, false, null);
		$reservationView->Resources = array($resource1);

		$this->authorizationService->_CanReserveFor = false;
		$this->authorizationService->_CanEditForResource = true;

		$canSeeDetails = $this->reservationAuthorization->CanViewDetails($reservationView, $this->currentUser);

		$this->assertTrue($canSeeDetails);
	}
}