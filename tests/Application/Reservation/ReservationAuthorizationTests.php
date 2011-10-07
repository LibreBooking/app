<?php

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

	public function testCanEditIfTheCurrentUserIsTheOwnerIfReservationHasNotEnded()
	{
		$endsInFuture = Date::Now()->AddDays(1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->EndDate = $endsInFuture;

		$isEditable = $this->reservationAuthorization->CanEdit($reservationView, $this->currentUser);

		$this->assertTrue($isEditable);
	}

	public function testIsNotEditableIfReservationHasEndedAndCurrentUserIsNotAdmin()
	{
		$endsInPast = Date::Now()->AddDays(-1);

		$reservationView = new ReservationView();
		$reservationView->OwnerId = $this->currentUser->UserId;
		$reservationView->EndDate = $endsInPast;

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
}
?>