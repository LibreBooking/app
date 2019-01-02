<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Ajax/ReservationCreditsPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationCreditsPresenter
{
    /**
     * @var IReservationCreditsPage
     */
    private $page;

    /**
     * @var IReservationViewRepository
     */
    private $reservationRepository;
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var IResourceRepository
     */
    private $resourceRepository;
    /**
     * @var IPaymentRepository
     */
    private $paymentRepository;

    public function __construct(IReservationCreditsPage $page,
                                IReservationRepository $reservationRepository,
                                IScheduleRepository $scheduleRepository,
                                IResourceRepository $resourceRepository,
                                IPaymentRepository $paymentRepository)
    {
        $this->page = $page;
        $this->reservationRepository = $reservationRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->resourceRepository = $resourceRepository;
        $this->paymentRepository = $paymentRepository;
    }

    public function PageLoad(UserSession $userSession)
    {
        if (!Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, new BooleanConverter())) {
            $this->page->SetCreditRequired(0, null);
            return;
        }

        $reservation = $this->GetReservation($userSession);
        $layout = $this->scheduleRepository->GetLayout($reservation->ScheduleId(), new ScheduleLayoutFactory($userSession->Timezone));
        $reservation->CalculateCredits($layout);
        $creditsRequired = $reservation->GetCreditsRequired();

        $cost = '';
        if (Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ALLOW_PURCHASE, new BooleanConverter())) {
            $creditCost = $this->paymentRepository->GetCreditCost();
            $cost = $creditCost->GetFormattedTotal($creditsRequired);
        }
        $this->page->SetCreditRequired($creditsRequired, $cost);
    }

    private function GetReservation(UserSession $userSession)
    {
        $referenceNumber = $this->page->GetReferenceNumber();

        if (empty($referenceNumber)) {
            $userId = $this->page->GetUserId();
            $primaryResourceId = $this->page->GetResourceId();
            $resource = $this->resourceRepository->LoadById($primaryResourceId);
            $roFactory = new RepeatOptionsFactory();
            $repeatOptions = $roFactory->CreateFromComposite($this->page, $userSession->Timezone);
            $duration = $this->GetReservationDuration($userSession);

            $reservationSeries = ReservationSeries::Create($userId, $resource, null, null, $duration, $repeatOptions, $userSession);

            $resourceIds = $this->GetAdditionalResourceIds();
            foreach ($resourceIds as $resourceId) {
                if ($primaryResourceId != $resourceId) {
                    $reservationSeries->AddResource($this->resourceRepository->LoadById($resourceId));
                }
            }

            return $reservationSeries;
        }
        else {
            $referenceNumber = $this->page->GetReferenceNumber();
            $existingSeries = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

            $resourceId = $this->page->GetResourceId();
            $resourceIds = $this->GetAdditionalResourceIds();

            if (empty($resourceId)) {
                // the first additional resource will become the primary if the primary is removed
                $resourceId = array_shift($additionalResourceIds);
            }

            $resource = $this->resourceRepository->LoadById($resourceId);
            $existingSeries->Update(
                $this->page->GetUserId(),
                $resource,
                null,
                null,
                $userSession);

            $existingSeries->UpdateDuration($this->GetReservationDuration($userSession));
            $roFactory = new RepeatOptionsFactory();

            $existingSeries->Repeats($roFactory->CreateFromComposite($this->page, $userSession->Timezone));

            $additionalResources = array();
            foreach ($resourceIds as $additionalResourceId) {
                if ($additionalResourceId != $resourceId) {
                    $additionalResources[] = $this->resourceRepository->LoadById($additionalResourceId);
                }
            }

            $existingSeries->ChangeResources($additionalResources);

            return $existingSeries;
        }
    }

    /**
     * @param UserSession $userSession
     * @return DateRange
     */
    private function GetReservationDuration(UserSession $userSession)
    {
        $startDate = $this->page->GetStartDate();
        $startTime = $this->page->GetStartTime();
        $endDate = $this->page->GetEndDate();
        $endTime = $this->page->GetEndTime();

        $timezone = $userSession->Timezone;
        return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
    }

    /**
     * @return array|int[]
     */
    private function GetAdditionalResourceIds()
    {
        $resourceIds = $this->page->GetResources();
        if (empty($resourceIds)) {
            $resourceIds = [];
        }
        return $resourceIds;
    }
}
