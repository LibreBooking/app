<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var IReservationAuthorization
	 */
	private $reservationAuthorization;

	/**
	 * @var IAttributeRepository
	 */
	private $attributeRepository;

	public function __construct(
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization,
		IAttributeRepository $attributeRepository,
		UserSession $userSession
	)
	{
		$this->user = $userSession;
		$this->reservationAuthorization = $reservationAuthorization;
		$this->attributeRepository = $attributeRepository;

		$this->userBinder = new ReservationUserBinder($userRepository, $reservationAuthorization);
		$this->dateBinder = new ReservationDateBinder($scheduleRepository);
		$this->resourceBinder = new ReservationResourceBinder($resourceService);
	}

	public function GetNewInitializer(INewReservationPage $page)
	{
		return new NewReservationInitializer($page,
			$this->userBinder,
			$this->dateBinder,
			$this->resourceBinder,
			new ReservationCustomAttributeBinder($this->attributeRepository),
			$this->user);
	}

	public function GetExisitingInitializer(IExistingReservationPage $page, ReservationView $reservationView)
	{
		return new ExistingReservationInitializer($page,
			$this->userBinder,
			$this->dateBinder,
			$this->resourceBinder,
			new ReservationDetailsBinder($this->reservationAuthorization, $page, $reservationView, new PrivacyFilter($this->reservationAuthorization)),
			new ReservationCustomAttributeValueBinder($this->attributeRepository, $reservationView),
			$reservationView,
			$this->user);
	}
}

?>