<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/Group/GroupResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Group/GroupsResponse.php');

class GroupsWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IGroupRepository
	 */
	private $groupRepository;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupViewRepository;

	public function __construct(IRestServer $server, IGroupRepository $groupRepository,
								IGroupViewRepository $groupViewRepository)
	{
		$this->server = $server;
		$this->groupRepository = $groupRepository;
		$this->groupViewRepository = $groupViewRepository;
	}

	/**
	 * @name GetAllGroups
	 * @description Loads all groups
	 * @response GroupsResponse
	 * @return void
	 */
	public function GetGroups()
	{
		$pageable = $this->groupViewRepository->GetList(null, null);
		$groups = $pageable->Results();

		$this->server->WriteResponse(new GroupsResponse($this->server, $groups));
	}

	/**
	 * @name GetGroup
	 * @description Loads a specific group by id
	 * @response GroupResponse
	 * @param int $groupId
	 * @return void
	 */
	public function GetGroup($groupId)
	{
		$group = $this->groupRepository->LoadById($groupId);

		if ($group != null)
		{
			$this->server->WriteResponse(new GroupResponse($this->server, $group));
		}
		else
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
	}
}

