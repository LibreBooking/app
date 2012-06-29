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


class ReservationAuthorizationTests extends TestBase
{
	/**
	 * @var IAuthorizationService|PHPUnit_Framework_MockObject_MockObject
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
	
	public function setup()
	{
		parent::setup();

		$this->authorizationService = $this->getMock('IAuthorizationService');

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

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertFalse($isEditable);
	}

	public function testIsNotEditableIfCurrentUserIsNotTheOwnerAndNotAuthorized()
	{
		$endsInFuture = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$ownerId = 92929;
		$reservationView->OwnerId = $ownerId;
		$reservationView->EndDate = $endsInFuture;

		$this->authorizationService->expects($this->once())
			->method('CanReserveFor')
			->with($this->equalTo($this->currentUser), $this->equalTo($ownerId))
			->will($this->returnValue(false));
					
		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertFalse($isEditable);
	}

	public function testCanEditPastReservationIfCurrentUserIsAdmin()
	{
		$endsInPast = Date::Now()->AddDays(-1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = 92929;
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

		$this->authorizationService->expects($this->once())
			->method('CanReserveFor')
			->with($this->equalTo($this->currentUser), $this->equalTo($ownerId))
			->will($this->returnValue(true));
		
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
        $resource1 = new ReservationResourceView(1, '', 1, 1);
        $reservationView->Resources = array($resource1);

        $this->authorizationService->expects($this->atLeastOnce())
            ->method('CanReserveFor')
            ->with($this->equalTo($this->currentUser), $this->equalTo($ownerId))
            ->will($this->returnValue(false));

        $this->authorizationService->expects($this->once())
            ->method('CanEditForResource')
            ->with($this->equalTo($this->currentUser), $this->equalTo($resource1))
            ->will($this->returnValue(true));

        $isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

        $this->assertTrue($isEditable);
    }

    public function testCanBeApprovedIfCurrentUserIsAuthorizedForAtLeastOneResource()
    {
        $endsInFuture = Date::Now()->AddDays(1);

        $reservationView = new ReservationView();
        $ownerId = 92929;
        $reservationView->OwnerId = $ownerId;
        $reservationView->EndDate = $endsInFuture;
        $reservationView->StatusId = ReservationStatus::Pending;
        $resource1 = new ReservationResourceView(1, '', 1, 1);
        $reservationView->Resources = array($resource1);

        $this->authorizationService->expects($this->atLeastOnce())
            ->method('CanApproveFor')
            ->with($this->equalTo($this->currentUser), $this->equalTo($ownerId))
            ->will($this->returnValue(false));

        $this->authorizationService->expects($this->once())
            ->method('CanApproveForResource')
            ->with($this->equalTo($this->currentUser), $this->equalTo($resource1))
            ->will($this->returnValue(true));

        $canBeApproved = $this->reservationAuthorization->CanApprove($reservationView, $this->currentUser);

        $this->assertTrue($canBeApproved);
    }

	public function testChecksResourceScheduleAdminGroup()
	{
		throw new Exception('should we load and check the resources schedule admin group id');
	}

	public function testCanChangeUsersIfTheCurrentUserIsAnAdminOrIsAuthorized()
	{
		$authorizedUser = new FakeUserSession();

		$this->authorizationService->expects($this->at(0))
				->method('CanReserveForOthers')
				->with($this->equalTo($this->currentUser))
				->will($this->returnValue(false));

		$this->authorizationService->expects($this->at(1))
				->method('CanReserveForOthers')
				->with($this->equalTo($authorizedUser))
				->will($this->returnValue(true));
		
		$asAdmin = $this->reservationAuthorization->CanChangeUsers($this->adminUser);
		$asUser = $this->reservationAuthorization->CanChangeUsers($this->currentUser);
		$asAuthorized = $this->reservationAuthorization->CanChangeUsers($authorizedUser);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asAuthorized);
		$this->assertFalse($asUser);
	}

	public function testCanApprovePendingReservationsIfTheCurrentUserIsAnAdminOrIsAuthorized()
	{
		$authorizedUser = new FakeUserSession();
		$reservationOwnerId = 123;
		
		$this->authorizationService->expects($this->at(0))
				->method('CanApproveFor')
				->with($this->equalTo($this->currentUser), $this->equalTo($reservationOwnerId))
				->will($this->returnValue(false));

		$this->authorizationService->expects($this->at(1))
				->method('CanApproveFor')
				->with($this->equalTo($authorizedUser), $this->equalTo($reservationOwnerId))
				->will($this->returnValue(true));

		$pendingReservation = new ReservationView();
		$pendingReservation->StatusId = ReservationStatus::Pending;
		$pendingReservation->OwnerId = $reservationOwnerId;
		
		$asAdmin = $this->reservationAuthorization->CanApprove($pendingReservation, $this->adminUser);
		$asUser = $this->reservationAuthorization->CanApprove($pendingReservation, $this->currentUser);
		$asAuthorized = $this->reservationAuthorization->CanApprove($pendingReservation, $authorizedUser);

		$this->assertTrue($asAdmin);
		$this->assertTrue($asAuthorized);
		$this->assertFalse($asUser);
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
		$resource1 = new ReservationResourceView(1, '', 1, 1);
		$reservationView->Resources = array($resource1);

		$this->authorizationService->expects($this->atLeastOnce())
			->method('CanReserveFor')
			->with($this->equalTo($this->currentUser), $this->equalTo($ownerId))
			->will($this->returnValue(false));

		$this->authorizationService->expects($this->once())
			->method('CanEditForResource')
			->with($this->equalTo($this->currentUser), $this->equalTo($resource1))
			->will($this->returnValue(true));

		$canSeeDetails = $this->reservationAuthorization->CanViewDetails($reservationView, $this->currentUser);

		$this->assertTrue($canSeeDetails);
	}
}
?>