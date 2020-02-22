<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');
require_once(ROOT_DIR . 'Pages/Reservation/ExistingReservationPage.php');

class ExistingReservationInitializer extends ReservationInitializerBase implements IReservationComponentInitializer
{
    /**
     * @var IExistingReservationPage
     */
    private $page;

    /**
     * @var ReservationView
     */
    private $reservationView;

    /**
     * @var IExistingReservationComponentBinder
     */
    private $reservationBinder;

    /**
     * @param IExistingReservationPage $page
     * @param IReservationComponentBinder $userBinder
     * @param IReservationComponentBinder $dateBinder
     * @param IReservationComponentBinder $resourceBinder
     * @param IReservationComponentBinder $reservationBinder
     * @param ReservationView $reservationView
     * @param UserSession $userSession
     * @param ITermsOfServiceRepository $termsOfServiceRepository
     */
    public function __construct(
        IExistingReservationPage $page,
        IReservationComponentBinder $userBinder,
        IReservationComponentBinder $dateBinder,
        IReservationComponentBinder $resourceBinder,
        IReservationComponentBinder $reservationBinder,
        ReservationView $reservationView,
        UserSession $userSession,
        ITermsOfServiceRepository $termsOfServiceRepository
    )
    {
        $this->page = $page;
        $this->reservationView = $reservationView;
        $this->reservationBinder = $reservationBinder;

        parent::__construct(
            $page,
            $userBinder,
            $dateBinder,
            $resourceBinder,
            $userSession,
            $termsOfServiceRepository);
    }

    public function Initialize()
    {
        parent::Initialize();

        $this->reservationBinder->Bind($this);
    }

    protected function SetSelectedDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
    {
        $timezone = $this->GetTimezone();
        $startDate = $this->reservationView->StartDate->ToTimezone($timezone);
        $endDate = $this->reservationView->EndDate->ToTimezone($timezone);

        parent::SetSelectedDates($startDate, $endDate, $startPeriods, $endPeriods);
    }

    public function GetOwnerId()
    {
        return $this->reservationView->OwnerId;
    }

    public function GetResourceId()
    {
        return $this->reservationView->ResourceId;
    }

    public function GetScheduleId()
    {
        return $this->reservationView->ScheduleId;
    }

    public function GetReservationDate()
    {
        return $this->reservationView->StartDate;
    }

    public function GetStartDate()
    {
        return $this->reservationView->StartDate;
    }

    public function GetEndDate()
    {
        return $this->reservationView->EndDate;
    }

    public function GetTimezone()
    {
        return ServiceLocator::GetServer()->GetUserSession()->Timezone;
    }
}