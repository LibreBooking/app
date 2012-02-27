<?php
/**
Copyright 2011-2012 Nick Korbel

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
 
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

class ResourceAdminManageReservationsPage extends ManageReservationsPage
{
	public function __construct()
	{
		parent::__construct();

		$this->presenter = new ManageReservationsPresenter($this,
					new ResourceAdminManageReservationsService(new ReservationViewRepository()),
					new ScheduleRepository(),
					new ResourceAdminResourceRepository(new ResourceRepository()));
	}
}

class ResourceAdminManageReservationsService implements IManageReservationsService
{

	/**
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter ReservationFilter
	 * @param $user UserSession
	 * @return PageableData
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		// TODO: Implement LoadFiltered() method.
	}
}

class ResourceAdminResourceRepository implements IResourceRepository
{
	public function __construct(IResourceRepository $repo)
	{

	}

	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId)
	{
		// TODO: Implement GetScheduleResources() method.
	}

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function LoadById($resourceId)
	{
		// TODO: Implement LoadById() method.
	}

	/**
	 * @param BookableResource $resource
	 * @return int ID of created resource
	 */
	public function Add(BookableResource $resource)
	{
		// TODO: Implement Add() method.
	}

	/**
	 * @param BookableResource $resource
	 */
	public function Update(BookableResource $resource)
	{
		// TODO: Implement Update() method.
	}

	/**
	 * @param BookableResource $resource
	 */
	public function Delete(BookableResource $resource)
	{
		// TODO: Implement Delete() method.
	}

	/**
	 * @return array|BookableResource[] array of all resources
	 */
	public function GetResourceList()
	{
		// TODO: Implement GetResourceList() method.
	}

	/**
	 * @return array|AccessoryDto[] all accessories
	 */
	public function GetAccessoryList()
	{
		// TODO: Implement GetAccessoryList() method.
	}
}

$page = new ResourceAdminManageReservationsPage();
if ($page->TakingAction())
{
	$page->ProcessAction();
}
else 
{
	$page->PageLoad();
}
?>