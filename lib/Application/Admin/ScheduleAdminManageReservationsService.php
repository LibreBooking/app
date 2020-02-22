<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */


class ScheduleAdminManageReservationsService extends ManageReservationsService implements IManageReservationsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	/**
	 * @param IReservationViewRepository $reservationViewRepository
	 * @param IUserRepository $userRepository
	 * @param IReservationAuthorization $authorization
	 * @param IReservationHandler|null $reservationHandler
	 * @param IUpdateReservationPersistenceService|null $persistenceService
	 */
	public function __construct(IReservationViewRepository $reservationViewRepository,
								IUserRepository $userRepository,
								IReservationAuthorization $authorization,
								$reservationHandler = null,
								$persistenceService = null)
	{
		parent::__construct($reservationViewRepository, $authorization, $reservationHandler, $persistenceService);

		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
	}

    /**
     * @param $pageNumber int
     * @param $pageSize int
     * @param null|string $sortField
     * @param null|string $sortDirection
     * @param $filter ReservationFilter
     * @param $user UserSession
     * @return PageableData|ReservationItemView[]
     */
	public function LoadFiltered($pageNumber, $pageSize, $sortField, $sortDirection, $filter, $user)
	{
		$groupIds = array();
		$groups = $this->userRepository->LoadGroups($user->UserId, RoleLevel::SCHEDULE_ADMIN);
		foreach ($groups as $group)
		{
			$groupIds[] = $group->GroupId;
		}

		$filter->_And(new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $groupIds));
		return $this->reservationViewRepository->GetList($pageNumber, $pageSize, $sortField, $sortDirection, $filter->GetFilter());
	}
}