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

class ReservationInitializerFactory implements IReservationInitializerFactory
{
    /**
     * @var ReservationUserBinder
     */
    private $userBinder;

    /**
     * @var ReservationDateBinder
     */
    private $dateBinder;

    /**
     * @var ReservationResourceBinder
     */
    private $resourceBinder;

    /**
     * @var IReservationAuthorization
     */
    private $reservationAuthorization;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(
        IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
        IReservationAuthorization $reservationAuthorization
    )
    {
        $this->reservationAuthorization = $reservationAuthorization;
        $this->userRepository = $userRepository;

        $this->userBinder = new ReservationUserBinder($userRepository, $reservationAuthorization);
        $this->dateBinder = new ReservationDateBinder($scheduleRepository);
        $this->resourceBinder = new ReservationResourceBinder($resourceService, $scheduleRepository);
    }

    public function GetNewInitializer(INewReservationPage $page)
    {
        return new NewReservationInitializer($page,
            $this->userBinder,
            $this->dateBinder,
            $this->resourceBinder,
            ServiceLocator::GetServer()->GetUserSession(),
            new ScheduleRepository(),
            new ResourceRepository(),
            new TermsOfServiceRepository());
    }

    public function GetExistingInitializer(IExistingReservationPage $page, ReservationView $reservationView)
    {
        return new ExistingReservationInitializer($page,
            $this->userBinder,
            $this->dateBinder,
            $this->resourceBinder,
            new ReservationDetailsBinder($this->reservationAuthorization, $page, $reservationView,
                new PrivacyFilter($this->reservationAuthorization)),
            $reservationView,
            ServiceLocator::GetServer()->GetUserSession(),
            new TermsOfServiceRepository()
        );
    }
}