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
	 * @var ParticipationPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();
		
		$this->page = $this->getMock('IParticipationPage');
		$this->reservationRepo = $this->getMock('IReservationRepository');

		$this->presenter = new ParticipationPresenter($this->page, $this->reservationRepo);
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

	private function assertUpdatesSeriesParticipation($invitationAction, $seriesMethod)
	{
		$currentUserId = 1029;
		$referenceNumber = 'abc123';
		$series = $this->getMock('ExistingReservationSeries');

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

		$this->presenter->PageLoad();
	}
}
?>
