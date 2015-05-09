<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/ParticipationPresenter.php');

class ParticipationPresenterTests extends TestBase
{
	/**
	 * @var IParticipationPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IReservationRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationRepo;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepo;

	/**
	 * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $scheduleRepository;

	/**
	 * @var ParticipationPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IParticipationPage');
		$this->reservationRepo = $this->getMock('IReservationRepository');
		$this->reservationViewRepo = $this->getMock('IReservationViewRepository');
		$this->scheduleRepository = $this->getMock('IScheduleRepository');

		$this->presenter = new ParticipationPresenter($this->page, $this->reservationRepo, $this->reservationViewRepo, $this->scheduleRepository);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenUserAcceptsInviteAndThereIsSpace()
	{
		$invitationAction = InvitationAction::Accept;
		$seriesMethod = 'AcceptInvitation';

		$this->assertUpdatesSeriesParticipation($invitationAction, $seriesMethod);
	}

	public function testWhenUserAcceptsInviteAndThereIsNotSpace()
	{
		$invitationAction = InvitationAction::Accept;

		$currentUserId = 1029;
		$referenceNumber = 'abc123';
		$builder = new ExistingReservationSeriesBuilder();
		$instance = new TestReservation();
		$instance->WithParticipants(array(1));
		$instance->WithInvitee($currentUserId);

		$resource = new FakeBookableResource(1);
		$resource->SetMaxParticipants(1);

		$builder->WithCurrentInstance($instance)
		->WithPrimaryResource($resource);

		$series = $builder->Build();

		$this->page->expects($this->once())
			->method('GetResponseType')
			->will($this->returnValue('json'));

		$this->page->expects($this->once())
			->method('GetInvitationAction')
			->will($this->returnValue($invitationAction));

		$this->page->expects($this->once())
			->method('GetInvitationReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($currentUserId));

		$this->reservationRepo->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($series));

		$this->page->expects($this->once())
			->method('DisplayResult')
			->with($this->stringContains('MaxParticipants'));

		$this->presenter->PageLoad();
	}

	public function testWhenUserJoinsAndThereIsSpace()
	{
		$invitationAction = InvitationAction::Join;
		$seriesMethod = 'JoinReservation';

		$this->assertUpdatesSeriesParticipation($invitationAction, $seriesMethod);
	}

	public function testWhenUserJoinsAndThereIsNotSpace()
	{
		$invitationAction = InvitationAction::Join;

		$currentUserId = 1029;
		$referenceNumber = 'abc123';
		$builder = new ExistingReservationSeriesBuilder();
		$instance = new TestReservation();
		$instance->WithParticipants(array(1));
		$instance->WithInvitee($currentUserId);

		$resource = new FakeBookableResource(1);
		$resource->SetMaxParticipants(1);

		$builder->WithCurrentInstance($instance)
			->WithPrimaryResource($resource);

		$series = $builder->Build();

		$this->page->expects($this->once())
			->method('GetResponseType')
			->will($this->returnValue('json'));

		$this->page->expects($this->once())
			->method('GetInvitationAction')
			->will($this->returnValue($invitationAction));

		$this->page->expects($this->once())
			->method('GetInvitationReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($currentUserId));

		$this->reservationRepo->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($series));

		$this->page->expects($this->once())
			->method('DisplayResult')
			->with($this->stringContains('ParticipationNotAllowed'));

		$this->presenter->PageLoad();
	}

	public function testWhenUserDeclinesInvite()
	{
		$invitationAction = InvitationAction::Decline;
		$seriesMethod = 'DeclineInvitation';

		$this->assertUpdatesSeriesParticipation($invitationAction, $seriesMethod);
	}

	public function testWhenUserCancelsAllParticipation()
	{
		$invitationAction = InvitationAction::CancelAll;
		$seriesMethod = 'CancelAllParticipation';

		$this->assertUpdatesSeriesParticipation($invitationAction, $seriesMethod);
	}

	public function testWhenUserCancelsInstanceParticipation()
	{
		$invitationAction = InvitationAction::CancelInstance;
		$seriesMethod = 'CancelInstanceParticipation';

		$this->assertUpdatesSeriesParticipation($invitationAction, $seriesMethod);
	}

	public function testWhenViewingOpenInvites()
	{
		$startDate = Date::Now();
		$endDate = $startDate->AddDays(30);
		$userId = $this->fakeUser->UserId;
		$inviteeLevel = ReservationUserLevel::INVITEE;

		$reservations[] = new ReservationItemView();
		$reservations[] = new ReservationItemView();
		$reservations[] = new ReservationItemView();

		$this->reservationViewRepo->expects($this->once())
				->method('GetReservationList')
				->with($this->equalTo($startDate), $this->equalTo($endDate), $this->equalTo($userId), $this->equalTo($inviteeLevel))
				->will($this->returnValue($reservations));

		$this->page->expects($this->once())
				->method('BindReservations')
				->with($this->equalTo($reservations));

		$this->presenter->PageLoad();
	}

	public function testWhenReservationStartConstraintIsViolated()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::FUTURE);

		$referenceNumber = 'abc';
		$currentUserId = 1029;

		$builder = new ExistingReservationSeriesBuilder();
		$instance = new TestReservation($referenceNumber, new DateRange(Date::Now()->AddMinutes(-1), Date::Now()->AddMinutes(30)), null);
		$builder->WithCurrentInstance($instance);

		$series = $builder->Build();

		$this->page->expects($this->once())
					->method('GetResponseType')
					->will($this->returnValue('json'));

		$this->page->expects($this->once())
				   ->method('GetInvitationAction')
				   ->will($this->returnValue(InvitationAction::Join));

		$this->page->expects($this->once())
			->method('GetInvitationReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($currentUserId));

		$this->reservationRepo->expects($this->once())
							  ->method('LoadByReferenceNumber')
							  ->with($this->equalTo($referenceNumber))
							  ->will($this->returnValue($series));

		$this->page->expects($this->once())
				   ->method('DisplayResult')
				   ->with($this->stringContains('ParticipationNotAllowed'));

		$this->presenter->PageLoad();
	}

	private function assertUpdatesSeriesParticipation($invitationAction, $seriesMethod)
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT, ReservationStartTimeConstraint::NONE);
		$currentUserId = 1029;
		$referenceNumber = 'abc123';
		$series = $this->getMock('ExistingReservationSeries');
		$series->expects($this->any())->method('GetAllowParticipation')->will($this->returnValue(true));
		$series->expects($this->any())->method('AllResources')->will($this->returnValue(array()));

		$this->page->expects($this->once())
			->method('GetResponseType')
			->will($this->returnValue('json'));

		$this->page->expects($this->once())
			->method('GetInvitationAction')
			->will($this->returnValue($invitationAction));

		$this->page->expects($this->once())
			->method('GetInvitationReferenceNumber')
			->will($this->returnValue($referenceNumber));

		$this->page->expects($this->once())
			->method('GetUserId')
			->will($this->returnValue($currentUserId));

		$this->reservationRepo->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($series));

		$series->expects($this->once())
			->method($seriesMethod)
			->with($this->equalTo($currentUserId));

		$this->reservationRepo->expects($this->once())
			->method('Update')
			->with($this->equalTo($series));

		$this->page->expects($this->once())
			->method('DisplayResult')
			->with($this->equalTo(null));

		$this->presenter->PageLoad();
	}
}