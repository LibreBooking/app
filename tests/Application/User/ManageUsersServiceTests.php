<?php
/**
Copyright 2013 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/User/ManageUsersService.php');

class ManageUsersServiceTests extends TestBase
{
	/**
	 * @var ManageUsersService
	 */
	private $service;

	/**
	 * @var IRegistration
	 */
	private $registration;

	/**
	 * @var IUserRepository
	 */
	private $userRepo;

	public function setup()
	{
		$this->registration = $this->getMock('IRegistration');
		$this->userRepo = $this->getMock('IUserRepository');
		$this->service = new ManageUsersService($this->registration, $this->userRepo);
	}

	public function testAddsUser()
	{
		$fname = 'f';
		$lname = 'l';
		$username = 'un';
		$email = 'e@mail.com';
		$timezone = 'America/Chicago';
		$lang = 'foo';
		$password = 'pw';

		$attributeId = 1;
		$attributeValue = 'value';
		$phone = 'phone';
		$position = 'position';
		$org = 'organization';
		$homePageId = 1;

		$userId = 99889;
		$user = new FakeUser($userId);

		$extraAttributes = array(UserAttribute::Phone => $phone, UserAttribute::Organization => $org, UserAttribute::Position => $position);
		$customAttributes = array(new AttributeValue($attributeId, $attributeValue));
		$this->registration->expects($this->once())
				->method('Register')
				->with($this->equalTo($username),
					   $this->equalTo($email),
					   $this->equalTo($fname),
					   $this->equalTo($lname),
					   $this->equalTo($password),
					   $this->equalTo($timezone),
					   $this->equalTo($lang),
					   $this->equalTo($homePageId),
					   $this->equalTo($extraAttributes),
					   $this->equalTo($customAttributes))
				->will($this->returnValue($user));

		$actualUserId = $this->service->AddUser($username,
												$email,
												$fname,
												$lname,
												$password,
												$timezone,
												$lang,
												$homePageId,
												$extraAttributes,
												$customAttributes);

		$this->assertEquals($userId, $actualUserId);
	}

	public function testUpdatesAttributes()
	{
		$attributeId = 1;
		$attributeValue = 'value';
		$userId = 111;
		$attributes = array(new AttributeValue($attributeId, $attributeValue));

		$user = new FakeUser($userId);

		$this->userRepo
				->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepo
				->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$this->service->ChangeAttributes($userId, $attributes);

		$this->assertEquals(1, count($user->GetAddedAttributes()));
		$this->assertEquals($attributeValue, $user->GetAttributeValue($attributeId));
	}

	public function testDeleteDelegatesToRepository()
	{
		$userId = 809;

		$this->userRepo->expects($this->once())
				->method('DeleteById')
				->with($this->equalTo($userId));

		$this->service->DeleteUser($userId);
	}

	public function testUpdatesUser()
	{
		$user = new User();
		$userId = 1029380;
		$fname = 'f';
		$lname = 'l';
		$username = 'un';
		$email = 'e@mail.com';
		$timezone = 'America/Chicago';
		$phone = '123-123-1234';
		$organization = 'ou';
		$position = 'position';

		$extraAttributes = array(
			UserAttribute::Organization => $organization,
			UserAttribute::Phone => $phone,
			UserAttribute::Position => $position);

		$this->userRepo->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$this->service->UpdateUser($userId, $username, $email, $fname, $lname, $timezone, $extraAttributes);

		$this->assertEquals($fname, $user->FirstName());
		$this->assertEquals($lname, $user->LastName());
		$this->assertEquals($timezone, $user->Timezone());

		$this->assertEquals($username, $user->Username());
		$this->assertEquals($email, $user->EmailAddress());
		$this->assertEquals($phone, $user->GetAttribute(UserAttribute::Phone));
		$this->assertEquals($organization, $user->GetAttribute(UserAttribute::Organization));
		$this->assertEquals($position, $user->GetAttribute(UserAttribute::Position));
	}

}

?>