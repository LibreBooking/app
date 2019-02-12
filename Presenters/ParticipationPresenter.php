<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/ParticipationPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

class ParticipationPresenter
{
    /**
     * @var IParticipationPage
     */
    private $page;

    /**
     * @var IReservationRepository
     */
    private $reservationRepository;

    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;
    /**
     * @var IParticipationNotification
     */
    private $participationNotification;

    public function __construct(IParticipationPage $page,
                                IReservationRepository $reservationRepository,
                                IReservationViewRepository $reservationViewRepository,
                                IParticipationNotification $participationNotification)
    {
        $this->page = $page;
        $this->reservationRepository = $reservationRepository;
        $this->reservationViewRepository = $reservationViewRepository;
        $this->participationNotification = $participationNotification;
    }

    public function PageLoad()
    {
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

        $reservations = $this->reservationViewRepository->GetReservations($startDate, $endDate, $userId, ReservationUserLevel::INVITEE);

        $this->page->SetTimezone($user->Timezone);
        $this->page->BindReservations($reservations);
        $this->page->DisplayParticipation();
    }

    /**
     * @param $invitationAction
     * @return string|null
     */
    private function HandleInvitationAction($invitationAction)
    {
        $user = ServiceLocator::GetServer()->GetUserSession();

        $referenceNumber = $this->page->GetInvitationReferenceNumber();
        $userId = $this->page->GetUserId();

        Log::Debug('Invitation action %s for user %s and reference number %s', $invitationAction, $userId, $referenceNumber);

        $series = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

        if ($invitationAction == InvitationAction::Join || $invitationAction == InvitationAction::CancelInstance) {
            $rules = array(new ReservationStartTimeRule(new ScheduleRepository()), new ResourceMinimumNoticeCurrentInstanceRuleUpdate($user), new ResourceMaximumNoticeCurrentInstanceRule($user));
        }
        else {
            $rules = array(new ReservationStartTimeRule(new ScheduleRepository()), new ResourceMinimumNoticeRuleAdd($user), new ResourceMaximumNoticeRule($user));
        }

        /** @var IReservationValidationRule $rule */
        foreach ($rules as $rule) {
            $ruleResult = $rule->Validate($series, null);

            if (!$ruleResult->IsValid()) {
                return $ruleResult->ErrorMessage();
            }
        }

        $error = null;
        if ($invitationAction == InvitationAction::Accept) {
            $series->AcceptInvitation($userId);

            $error = $this->CheckCapacityAndReturnAnyError($series);
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
        if ($invitationAction == InvitationAction::Join) {
            if (!$series->GetAllowParticipation()) {
                $error = Resources::GetInstance()->GetString('ParticipationNotAllowed');
            }
            else {
                $series->JoinReservation($userId);
                $error = $this->CheckCapacityAndReturnAnyError($series);
            }
        }
        if ($invitationAction == InvitationAction::JoinAll) {
            if (!$series->GetAllowParticipation()) {
                $error = Resources::GetInstance()->GetString('ParticipationNotAllowed');
            }
            else {
                $series->JoinReservationSeries($userId);
                $error = $this->CheckCapacityAndReturnAnyError($series);
            }
        }

        if (empty($error)) {
            $this->reservationRepository->Update($series);
            $this->participationNotification->Notify($series, $userId, $invitationAction);
        }

        return $error;
    }

    /**
     * @param ExistingReservationSeries $series
     * @return mixed|null|string
     */
    private function CheckCapacityAndReturnAnyError($series)
    {
        foreach ($series->AllResources() as $resource) {
            if (!$resource->HasMaxParticipants()) {
                continue;
            }

            /** @var $instance Reservation */
            foreach ($series->Instances() as $instance) {
                $numberOfParticipants = count($instance->Participants()) + count($instance->ParticipatingGuests());
                if ($numberOfParticipants > $resource->GetMaxParticipants()) {
                    return Resources::GetInstance()->GetString('MaxParticipantsError', array($resource->GetName(), $resource->GetMaxParticipants()));
                }
            }
        }

        return null;
    }
}