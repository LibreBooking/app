<?php
/**
Copyright 2017-2018 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeGroupViewRepository implements IGroupViewRepository
{
	private $_groupList = array();

	public function __construct()
	{
	}

	/**
	 * @param GroupItemView $groupItemView
	 */
	public function _AddGroup($groupItemView)
	{
		$this->_groupList[] = $groupItemView;
	}
	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string $sortField
	 * @param string $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData|GroupItemView[]
	 */
	public function GetList($pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null,
							$filter = null)
	{
		return new PageableData($this->_groupList);
	}

	/**
	 * @param int|array|int[] $groupIds
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param ISqlFilter $filter
	 * @param AccountStatus|int $accountStatus
	 * @return PageableData|GroupUserView[]
	 */
	public function GetUsersInGroup($groupIds, $pageNumber = null, $pageSize = null, $filter = null,
									$accountStatus = AccountStatus::ALL)
	{
		// TODO: Implement GetUsersInGroup() method.
	}

	/**
	 * @param $roleLevel int|RoleLevel
	 * @return GroupItemView[]|array
	 */
	public function GetGroupsByRole($roleLevel)
	{
		// TODO: Implement GetGroupsByRole() method.
	}
}
