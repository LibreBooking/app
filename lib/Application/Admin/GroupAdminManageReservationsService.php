<?php
/**
Copyright 2012-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupAdminManageReservationsService extends ManageReservationsService implements IManageReservationsService
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IReservationViewRepository $reservationViewRepository, IUserRepository $userRepository, IReservationAuthorization $authorization)
    {
		parent::__construct($reservationViewRepository, $authorization);

        $this->userRepository = $userRepository;
    }

    /**
     * @param $pageNumber int
     * @param $pageSize int
     * @param $filter ReservationFilter
     * @param $userSession UserSession
     * @return PageableData
     */
    public function LoadFiltered($pageNumber, $pageSize, $filter, $userSession)
    {
        $user = $this->userRepository->LoadById($userSession->UserId);

        $adminGroups = $user->GetAdminGroups();
        $groupIds = array();
        foreach ($adminGroups as $group)
        {
            $groupIds[] = $group->GroupId;
        }

        $command = new GetFullGroupReservationListCommand($groupIds);

        if ($filter != null)
        {
            $command = new FilterCommand($command, $filter->GetFilter());
        }

        $builder = array('ReservationItemView', 'Populate');
        return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
    }
}
