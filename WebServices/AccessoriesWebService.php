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
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/AccessoriesResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/AccessoryResponse.php');

class AccessoriesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAccessoryRepository
	 */
	private $accessoryRepository;

	public function __construct(IRestServer $server, IResourceRepository $resourceRepository,
								IAccessoryRepository $accessoryRepository)
	{
		$this->server = $server;
		$this->resourceRepository = $resourceRepository;
		$this->accessoryRepository = $accessoryRepository;
	}

	/**
	 * @name GetAllAccessories
	 * @description Loads all accessories
	 * @response AccessoriesResponse
	 * @return void
	 */
	public function GetAll()
	{
		$accessories = $this->resourceRepository->GetAccessoryList();
		$this->server->WriteResponse(new AccessoriesResponse($this->server, $accessories));
	}

	/**
	 * @name GetAccessory
	 * @description Loads a specific accessory by id
	 * @param int $accessoryId
	 * @response AccessoryResponse
	 * @return void
	 */
	public function GetAccessory($accessoryId)
	{
		$accessory = $this->accessoryRepository->LoadById($accessoryId);

		if (empty($accessory))
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
		else
		{
			$this->server->WriteResponse(new AccessoryResponse($this->server, $accessory));
		}
	}
}
