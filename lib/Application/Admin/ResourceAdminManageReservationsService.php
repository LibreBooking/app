<?php
/**
Copyright 2012 Nick Korbel

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

class ResourceAdminManageReservationsService implements IManageReservationsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository, IUserRepository $userRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
	}
	/**
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter ReservationFilter
	 * @param $user UserSession
	 * @return PageableData
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		$groupIds = array();
		$groups = $this->userRepository->LoadGroups($user->UserId, RoleLevel::RESOURCE_ADMIN);
		foreach ($groups as $group)
		{
			$groupIds[] = $group->GroupId;
		}

		$filter->_And(new SqlFilterIn(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupIds));
		return $this->reservationViewRepository->GetList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}
}

?>