<?php
/**
 * Copyright 2013-2014 Nick Korbel
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

class AdminExcludedRuleTests extends TestBase
{
	/**
	 * @var AdminExcludedRule
	 */
	private $rule;

	/**
	 * @var IReservationValidationRule|PHPUnit_Framework_MockObject_MockObject
	 */
	private $baseRule;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var User|PHPUnit_Framework_MockObject_MockObject
	 */
	private $user;

	/**
	 * @var TestReservationSeries
	 */
	private $reservationSeries;

	private $resource1;
	private $resource2;

	public function setup()
	{
		parent::setup();

		$this->userRepository = $this->getMock('IUserRepository');
		$this->baseRule = $this->getMock('IReservationValidationRule');
		$this->user =  $this->getMock('User');

		$this->rule = new AdminExcludedRule($this->baseRule, $this->fakeUser, $this->userRepository);

		$this->reservationSeries = new TestReservationSeries();
		$this->resource1 = new FakeBookableResource(1);
		$this->resource2 = new FakeBookableResource(2);

		$this->reservationSeries->WithResource($this->resource1);
		$this->reservationSeries->AddResource($this->resource2);
	}

	public function testIfUserIsApplicationAdmin_ReturnTrue()
	{
		$this->fakeUser->IsAdmin = true;

		$result = $this->rule->Validate($this->reservationSeries);

		$this->assertTrue($result->IsValid());
	}

	public function testIfUserIsAdminForAllResources_ReturnTrue()
	{
		$this->fakeUser->IsAdmin = false;
		$this->fakeUser->IsScheduleAdmin = true;

		$this->userRepository->expects($this->once())
					->method('LoadById')
					->with($this->equalTo($this->fakeUser->UserId))
					->will($this->returnValue($this->user));

		$this->user->expects($this->at(0))
					->method('IsResourceAdminFor')
					->with($this->equalTo($this->resource1))
					->will($this->returnValue(true));

		$this->user->expects($this->at(1))
					->method('IsResourceAdminFor')
					->with($this->equalTo($this->resource2))
					->will($this->returnValue(true));

		$result = $this->rule->Validate($this->reservationSeries);

		$this->assertTrue($result->IsValid());
	}

	public function testIfUserIsNotAdminForAtLeastOneResource_InvokeBaseRule()
	{
		$expectedResult = new ReservationValidationResult(false, array('some error'));
		$this->fakeUser->IsAdmin = false;

		$this->userRepository->expects($this->once())
					->method('LoadById')
					->with($this->equalTo($this->fakeUser->UserId))
					->will($this->returnValue($this->user));

		$this->user->expects($this->at(0))
					->method('IsResourceAdminFor')
					->with($this->equalTo($this->resource1))
					->will($this->returnValue(true));

		$this->user->expects($this->at(1))
					->method('IsResourceAdminFor')
					->with($this->equalTo($this->resource2))
					->will($this->returnValue(false));

		$this->baseRule->expects($this->once())
					->method('Validate')
					->with($this->equalTo($this->reservationSeries))
					->will($this->returnValue($expectedResult));

		$result = $this->rule->Validate($this->reservationSeries);

		$this->assertEquals($expectedResult, $result);
	}

	public function testIfUserIsAdminForReservationUserReturnTrue()
	{
		$this->fakeUser->IsAdmin = false;
		$this->fakeUser->IsGroupAdmin = true;

		$adminUser =  $this->getMock('User');
		$reservationUser =  $this->getMock('User');

		$this->userRepository->expects($this->at(0))
							->method('LoadById')
							->with($this->equalTo($this->fakeUser->UserId))
							->will($this->returnValue($adminUser));

		$this->userRepository->expects($this->at(1))
							->method('LoadById')
							->with($this->equalTo($this->reservationSeries->UserId()))
							->will($this->returnValue($reservationUser));

		$adminUser->expects($this->once())
					->method('IsAdminFor')
					->with($this->equalTo($reservationUser))
					->will($this->returnValue(true));

		$result = $this->rule->Validate($this->reservationSeries);

		$this->assertTrue($result->IsValid());
	}
}