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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupAdminManageReservationsService implements IManageReservationsService
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
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

?>