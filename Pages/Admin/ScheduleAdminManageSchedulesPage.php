<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/ManageSchedulesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');


class ScheduleAdminManageSchedulesPage extends ManageSchedulesPage
{
	public function __construct()
	{
		parent::__construct();

		$userRepository = new UserRepository();
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->_presenter = new ManageSchedulesPresenter($this,
														 new ScheduleAdminManageScheduleService(
															 new ScheduleAdminScheduleRepository($userRepository, $user),
															 new ScheduleRepository(),
															 new ResourceAdminResourceRepository($userRepository, $user)),
														 new GroupRepository());
	}
}

class ScheduleAdminManageScheduleService extends ManageScheduleService
{
	/**
	 * @var IScheduleRepository
	 */
	private $adminScheduleRepo;
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepo;
	/**
	 * @var IResourceRepository
	 */
	private $adminResourceRepo;

	public function __construct(IScheduleRepository $adminScheduleRepo, IScheduleRepository $scheduleRepo, IResourceRepository $adminResourceRepo)
	{
		$this->adminScheduleRepo = $adminScheduleRepo;
		$this->scheduleRepo = $scheduleRepo;
		$this->adminResourceRepo = $adminResourceRepo;
		parent::__construct($adminScheduleRepo, $adminResourceRepo);
	}

	public function GetAll()
	{
		return $this->adminScheduleRepo->GetAll();
	}

	public function GetSourceSchedules()
	{
		return $this->scheduleRepo->GetAll();
	}
}

?>