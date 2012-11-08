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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourcesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(IRestServer $server, IResourceRepository $resourceRepository)
	{
		$this->server = $server;
		$this->resourceRepository = $resourceRepository;
	}

	public function GetAll()
	{

	}

	/**
	 * @name GetResource
	 * @description Loads a specific resource by id
	 * @param int $resourceId
	 * @response ResourceResponse
	 * @return void
	 */
	public function GetResource($resourceId)
	{
		$resource = $this->resourceRepository->LoadById($resourceId);

		$this->server->WriteResponse(new ResourceResponse($this->server, $resource));
	}

}

class ResourceResponse extends RestResponse
{
	/**
	 * @param IRestServer $server
	 * @param BookableResource $resource
	 */
	public function __construct($server = null, $resource = null)
	{

	}
}

?>