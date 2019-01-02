<?php
/**
Copyright 2017-2019 Nick Korbel

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

class FakeUserRepository implements IUserRepository
{
    /**
     * @var FakeUser
     */
	public $_User;
    /**
     * @var FakeUser
     */
    public $_UpdatedUser;
    /**
     * @var FakeUser
     */
    public $_AddedUser;

    public $_Exists = true;

    /**
     * @var UserDto
     */
    public $_UserDto;
    /**
     * @var UserDto[]
     */
    public $_UserDtos;

    public function __construct()
	{
		$this->_User = new FakeUser(123);
	}
	/**
	 * @param int $userId
	 * @return User
	 */
	function LoadById($userId)
	{
		return $this->_User;
	}

	/**
	 * @param string $publicId
	 * @return User
	 */
	function LoadByPublicId($publicId)
	{
		return $this->_User;
	}

	/**
	 * @param string $userName
	 * @return User
	 */
	function LoadByUsername($userName)
	{
		return $this->_User;
	}

	/**
	 * @param User $user
	 * @return void
	 */
	function Update(User $user)
	{
		$this->_UpdatedUser = $user;
	}

	/**
	 * @param User $user
	 * @return int
	 */
	function Add(User $user)
	{
        $this->_AddedUser = $user;

    }

	/**
	 * @param $userId int
	 * @return void
	 */
	function DeleteById($userId)
	{
		// TODO: Implement DeleteById() method.
	}

	/**
	 * @param int $userId
	 * @return UserDto
	 */
	function GetById($userId)
	{
		if ($this->_UserDto != null)
        {
            return $this->_UserDto;
        }

        return $this->_UserDtos[$userId];
	}

	/**
	 * @return array[int]UserDto
	 */
	function GetAll()
	{
		// TODO: Implement GetAll() method.
	}

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param null|string $sortField
	 * @param null|string $sortDirection
	 * @param null|ISqlFilter $filter
	 * @param AccountStatus|int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null,
							$accountStatus = AccountStatus::ALL)
	{
		// TODO: Implement GetList() method.
	}

	/**
	 * @param int $resourceId
	 * @return array|UserDto[]
	 */
	function GetResourceAdmins($resourceId)
	{
		// TODO: Implement GetResourceAdmins() method.
	}

	/**
	 * @return array|UserDto[]
	 */
	function GetApplicationAdmins()
	{
		// TODO: Implement GetApplicationAdmins() method.
	}

	/**
	 * @param int $userId
	 * @return array|UserDto[]
	 */
	function GetGroupAdmins($userId)
	{
		// TODO: Implement GetGroupAdmins() method.
	}

	/**
	 * @param $userId int
	 * @param $roleLevels int|null|array|int[]
	 * @return array|UserGroup[]
	 */
	function LoadGroups($userId, $roleLevels = null)
	{
		// TODO: Implement LoadGroups() method.
	}

	/**
	 * @param string $emailAddress
	 * @param string $userName
	 * @return int|null
	 */
	public function UserExists($emailAddress, $userName)
	{
		return $this->_Exists;
	}

	/**
	 * @return int
	 */
	public function GetCount()
	{
		// TODO: Implement GetCount() method.
	}
}