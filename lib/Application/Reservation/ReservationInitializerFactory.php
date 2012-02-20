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
	 * @var IScheduleUserRepository
	 */
	private $_scheduleUserRepository;

	/**
	 * @var IScheduleRepository
	 */
	private $_scheduleRepository;

	/**
	 * @var IUserRepository
	 */
	private $_userRepository;

	/**
	 * @var IResourceService
	 */
	private $_resourceService;

	/**
	 * @var IReservationAuthorization
	 */
	private $_reservationAuthorization;

	public function __construct(
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization,
		UserSession $userSession
	)
	{
		$this->_scheduleUserRepository = $scheduleUserRepository;
		$this->_scheduleRepository = $scheduleRepository;
		$this->_userRepository = $userRepository;
		$this->_resourceService = $resourceService;
		$this->_reservationAuthorization = $reservationAuthorization;
		$this->_user = $userSession;
	}

	public function GetNewInitializer(INewReservationPage $page)
	{
		return new NewReservationInitializer($page,
			$this->_scheduleRepository,
			$this->_userRepository,
			$this->_resourceService,
			$this->_reservationAuthorization,
			$this->_user);
	}

	public function GetExisitingInitializer(IExistingReservationPage $page, ReservationView $reservationView)
	{
		return new ExistingReservationInitializer($page,
			$this->_scheduleRepository,
			$this->_userRepository,
			$this->_resourceService,
			$reservationView,
			$this->_reservationAuthorization,
			$this->_user);
	}
}

?>