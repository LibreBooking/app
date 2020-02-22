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

class GroupAdminUserRepository extends UserRepository
{
    /**
     * @var IGroupViewRepository
     */
    private $groupRepository;

    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(IGroupViewRepository $groupRepository, UserSession $userSession)
    {
        $this->groupRepository = $groupRepository;
        $this->userSession = $userSession;
        parent::__construct();
    }

    public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null, $accountStatus = AccountStatus::ALL)
    {
		if (empty($accountStatus))
		{
			$accountStatus = AccountStatus::ALL;
		}

        $user = parent::LoadById($this->userSession->UserId);

        $groupIds = array();

        foreach ($user->GetAdminGroups() as $group)
        {
            $groupIds[] = $group->GroupId;
        }

        return $this->groupRepository->GetUsersInGroup($groupIds, $pageNumber, $pageSize, $filter, $accountStatus);
    }

	/**
	 * @param int $userId
	 * @return User|void
	 */
	public function LoadById($userId)
	{
		$user = parent::LoadById($userId);
		$me = parent::LoadById($this->userSession->UserId);

		if ($userId == $this->userSession->UserId || $me->IsAdminFor($user))
		{
			return $user;
		}

		return User::Null();
	}
}
