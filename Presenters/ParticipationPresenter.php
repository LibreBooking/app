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


require_once(ROOT_DIR . 'Pages/ParticipationPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ParticipationPresenter {

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

    public function __construct(IParticipationPage $page, IReservationRepository $reservationRepository, IReservationViewRepository $reservationViewRepository) {
        $this->page = $page;
        $this->reservationRepository = $reservationRepository;
        $this->reservationViewRepository = $reservationViewRepository;
    }

    public function PageLoad() {
        $invitationAction = $this->page->GetInvitationAction();

        if (!empty($invitationAction)) {
            $resultString = $this->HandleInvitationAction($invitationAction);

            if ($this->page->GetResponseType() == 'json') {
                $this->page->DisplayResult($resultString);
                return;
            }

			$this->page->SetResult($resultString);
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

	/**
	 * @param $invitationAction
	 * @return string|null
	 */
	private function HandleInvitationAction($invitationAction) {
        $referenceNumber = $this->page->GetInvitationReferenceNumber();
        $userId = $this->page->GetUserId();

        Log::Debug('Invitation action %s for user %s and reference number %s', $invitationAction, $userId, $referenceNumber);

        $series = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

        if ($invitationAction == InvitationAction::Accept) {

			$series->AcceptInvitation($userId);

			foreach ($series->AllResources() as $resource)
			{
				if (!$resource->HasMaxParticipants())
				{
					continue;
				}

				/** @var $instance Reservation */
				foreach ($series->Instances() as $instance)
				{
					$numberOfParticipants = count($instance->Participants());

					if ($numberOfParticipants > $resource->GetMaxParticipants())
					{
						return Resources::GetInstance()->GetString('MaxParticipantsError', array($resource->GetName(), $resource->GetMaxParticipants()));
					}
				}
			}
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

		return null;
    }

}

?>