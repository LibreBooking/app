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

require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class ScheduleAdminScheduleRepositoryTests extends TestBase
{
	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $userRepository;

	/**
	 * @var FakeUserSession
	 */
	public $user;

	/**
	 * @var ScheduleAdminScheduleRepository
	 */
	public $repo;

	public function setup()
	{
		$this->userRepository = $this->getMock('IUserRepository');
		$this->user = new FakeUserSession();
		$this->repo = new ScheduleAdminScheduleRepository($this->userRepository, $this->user);

		parent::setup();
	}

	public function testOnlyGetsSchedulesWhereUserIsAdmin()
	{
		$user = $this->getMock('User');
		$this->userRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($this->fakeUser->UserId))
				->will($this->returnValue($user));

		$ra = new FakeScheduleRepository();
		$this->db->SetRows($ra->GetRows());

		$user->expects($this->at(0))
				->method('IsScheduleAdminFor')
				->with($this->equalTo($ra->_AllRows[0]))
				->will($this->returnValue(false));

		$user->expects($this->at(1))
				->method('IsScheduleAdminFor')
				->with($this->equalTo($ra->_AllRows[1]))
				->will($this->returnValue(true));

		$schedules = $this->repo->GetAll();

		$this->assertTrue($this->db->ContainsCommand(new GetAllSchedulesCommand()));
		$this->assertEquals(1, count($schedules));
		$this->assertEquals(2, $schedules[0]->GetId());
	}

	public function testDoesNotUpdateScheduleIfUserDoesNotHaveAccess()
	{
		$user = $this->getMock('User');
		$this->userRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($this->fakeUser->UserId))
				->will($this->returnValue($user));

		$schedule = new FakeSchedule(1);
		$schedule->SetAdminGroupId(2);

		$user->expects($this->at(0))
				->method('IsScheduleAdminFor')
				->with($this->equalTo($schedule))
				->will($this->returnValue(false));

		$actualEx = null;
		try
		{
			$this->repo->Update($schedule);
		}
		catch (Exception $ex)
		{
			$actualEx = $ex;

		}
		$this->assertNotEmpty($actualEx, "should have thrown an exception");
	}
}

?>