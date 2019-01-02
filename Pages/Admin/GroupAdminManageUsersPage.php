<?php
/**
Copyright 2013-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class GroupAdminManageUsersPage extends ManageUsersPage
{
	public function __construct()
	{
		parent::__construct();
		$this->_presenter->SetUserRepository(new GroupAdminUserRepository(new GroupRepository(), ServiceLocator::GetServer()->GetUserSession()));
		$groupRepository = new GroupAdminGroupRepository(new UserRepository(), ServiceLocator::GetServer()->GetUserSession());
		$this->_presenter->SetGroupRepository($groupRepository);
		$this->_presenter->SetGroupViewRepository($groupRepository);
	}

    protected function RenderTemplate()
    {
		$this->Set('ManageGroupsUrl', Pages::MANAGE_GROUPS_ADMIN);
        $this->Set('ManageReservationsUrl', Pages::MANAGE_GROUP_RESERVATIONS);
        parent::RenderTemplate();
    }

}

