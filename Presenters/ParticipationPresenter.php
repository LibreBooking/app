<?php
require_once(ROOT_DIR . 'Pages/ParticipationPage.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class ParticipationPresenter
{
	/**
	 * @var \IParticipationPage
	 */
	private $page;

	/**
	 * @var \IReservationRepository
	 */
	private $reservationRepository;
	
	public function __construct(IParticipationPage $page, IReservationRepository $reservationRepository)
	{
		$this->page = $page;
		$this->reservationRepository = $reservationRepository;
	}

	public function PageLoad()
	{
		$invitationAction = $this->page->GetInvitationAction();

		if (!empty($invitationAction))
		{
			$this->HandleInvitationAction($invitationAction);
		}
		else
		{

		}
	}

	private function HandleInvitationAction($invitationAction)
	{
		$referenceNumber = $this->page->GetInvitationReferenceNumber();
		$userId = $this->page->GetUserId();

		$series = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

		if ($invitationAction == InvitationAction::Accept) {
			$series->AcceptInvitation($userId);
		}
		if ($invitationAction == InvitationAction::Decline) {
			$series->DeclineInvitation($userId);
		}
		if ($invitationAction == InvitationAction::CancelInstance) {
			$series->CancelInstanceParticipation($userId);
		}
		if ($invitationAction == InvitationAction::CancelAll) {
			$series->CancelAllParticipation($userId);
		}

		$this->reservationRepository->Update($series);
	}
}
?>
