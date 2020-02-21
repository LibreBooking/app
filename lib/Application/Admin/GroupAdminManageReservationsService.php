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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupAdminManageReservationsService extends ManageReservationsService implements IManageReservationsService
{
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

        $this->userRepository = $userRepository;
    }

    /**
     * @param $pageNumber int
     * @param $pageSize int
     * @param null|string $sortField
     * @param null|string $sortDirection
     * @param $filter ReservationFilter
     * @param $userSession UserSession
     * @return PageableData|ReservationItemView[]
     */
    public function LoadFiltered($pageNumber, $pageSize, $sortField, $sortDirection, $filter, $userSession)
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
        return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize, $sortField, $sortDirection);
    }
}
