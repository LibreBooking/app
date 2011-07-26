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
			$referenceNumber = $this->page->GetInvitationReferenceNumber();
			$userId = $this->page->GetUserId();
			
			$series = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

			if ($invitationAction == InvitationAction::Accept)
			{
				$series->AcceptInvitation($userId);
			}
			if ($invitationAction == InvitationAction::Decline)
			{
				$series->DeclineInvitation($userId);
			}
			
			$this->reservationRepository->Update($series);
		}
		else
		{

		}
	}
}
?>
