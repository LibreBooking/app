<?php
require_once(ROOT_DIR . 'Presenters/ParticipationPresenter.php');

class ParticipationPresenterTests extends TestBase
{
	/**
	 * @var IParticipationPage
	 */
	private $page;

	/**
	 * @var IReservationRepository
	 */
	private $reservationRepo;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepo;

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

		$this->presenter = new ParticipationPresenter($this->page, $this->reservationRepo, $this->reservationViewRepo);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenUserAcceptsInvite()
	{
		$invitationAction = InvitationAction::Accept;
		$seriesMethod = 'AcceptInvitation';

		$this->assertUpdatesSeriesParticipation($invitationAction, $seriesMethod);
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

	private function assertUpdatesSeriesParticipation($invitationAction, $seriesMethod)
	{
		$currentUserId = 1029;
		$referenceNumber = 'abc123';
		$series = $this->getMock('ExistingReservationSeries');

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
?>