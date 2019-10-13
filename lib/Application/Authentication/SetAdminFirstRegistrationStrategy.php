<?php
/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IFirstRegistrationStrategy
{
	public function HandleLogin(User $user, IUserRepository $userRepository, IGroupRepository $groupRepository);
}

class SetAdminFirstRegistrationStrategy implements IFirstRegistrationStrategy
{
	public function HandleLogin(User $user, IUserRepository $userRepository, IGroupRepository $groupRepository)
	{
		$users = $userRepository->GetCount();
		if ($users == 1)
		{
			$configFile = ROOT_DIR . 'config/config.php';

			if (file_exists($configFile))
			{
				$str = file_get_contents($configFile);
				$str = str_replace("admin@example.com", $user->EmailAddress(), $str);
				file_put_contents($configFile, $str);
				$this->ReloadCachedConfig();
			}

			$groupId = $groupRepository->Add(new Group(0, 'Administrators'));
			$adminGroup = $groupRepository->LoadById($groupId);
			$adminGroup->ChangeRoles(array(RoleLevel::APPLICATION_ADMIN));
			$adminGroup->AddUser($user->Id());
			$groupRepository->Update($adminGroup);
		}
	}

	private function ReloadCachedConfig()
	{
		Configuration::SetInstance(null);
	}
}