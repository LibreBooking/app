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

	/**
	 * @var \IReservationViewRepository
	 */
	private $reservationViewRepository;
	
	public function __construct(IParticipationPage $page, IReservationRepository $reservationRepository, IReservationViewRepository $reservationViewRepository)
	{
		$this->page = $page;
		$this->reservationRepository = $reservationRepository;
		$this->reservationViewRepository = $reservationViewRepository;
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

		$startDate = Date::Now();
		$endDate = $startDate->AddDays(30);
		$user = ServiceLocator::GetServer()->GetUserSession();
		$userId = $user->UserId;

		$reservations = $this->reservationViewRepository->GetReservationList($startDate, $endDate, $userId, ReservationUserLevel::INVITEE);

		$this->page->SetTimezone($user->Timezone);
		$this->page->BindReservations($reservations);
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