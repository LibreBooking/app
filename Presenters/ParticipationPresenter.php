<?php
require_once(ROOT_DIR . 'Pages/ParticipationPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

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

			if ($this->page->GetResponseType() == 'json')
			{
				$this->page->DisplayResult(null);
				return;
			}
		}

		$this->page->DisplayParticipation();
	}

	private function HandleInvitationAction($invitationAction)
	{
		$referenceNumber = $this->page->GetInvitationReferenceNumber();
		$userId = $this->page->GetUserId();

		Log::Debug('Invitation action %s for user %s and reference number %s', $invitationAction, $userId, $referenceNumber);
		
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
