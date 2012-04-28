<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @var ReservationDetailsBinder
	 */
	private $reservationBinder;

	/**
	 * @var UserSession
	 */
	private $user;

	public function __construct(
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization,
		UserSession $userSession
	)
	{
		$this->user = $userSession;

		$this->userBinder = new ReservationUserBinder($userRepository, $reservationAuthorization);
		$this->dateBinder = new ReservationDateBinder($scheduleRepository);
		$this->resourceBinder = new ReservationResourceBinder($resourceService);
		$this->reservationBinder = new ReservationDetailsBinder($reservationAuthorization);
	}

	public function GetNewInitializer(INewReservationPage $page)
	{
		return new NewReservationInitializer($page,
			$this->userBinder,
			$this->dateBinder,
			$this->resourceBinder,
			$this->user);
	}

	public function GetExisitingInitializer(IExistingReservationPage $page, ReservationView $reservationView)
	{
		return new ExistingReservationInitializer($page,
			$this->userBinder,
			$this->dateBinder,
			$this->resourceBinder,
			$this->reservationBinder,
			$reservationView,
			$this->user);
	}
}

?>