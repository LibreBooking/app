<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');

class ManageUsersPresenterTests extends TestBase
{
	/**
	 * @var IManageUsersPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var UserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $userRepo;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $resourceRepo;

	/**
	 * @var IManageUsersService|PHPUnit_Framework_MockObject_MockObject
	 */
	public $manageUsersService;

	/**
	 * @var ManageUsersPresenter
	 */
	public $presenter;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	public $attributeService;

	/**
	 * @var PasswordEncryption
	 */
	public $encryption;

	/**
	 * @var IGroupRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $groupRepository;

	/**
	 * @var IGroupViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $groupViewRepository;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageUsersPage');
		$this->userRepo = $this->getMock('UserRepository');
		$this->resourceRepo = $this->getMock('IResourceRepository');
		$this->encryption = $this->getMock('PasswordEncryption');
		$this->manageUsersService = $this->getMock('IManageUsersService');
		$this->attributeService = $this->getMock('IAttributeService');
		$this->groupRepository = $this->getMock('IGroupRepository');
		$this->groupViewRepository = $this->getMock('IGroupViewRepository');

		$this->presenter = new ManageUsersPresenter($this->page,
													$this->userRepo,
													$this->resourceRepo,
													$this->encryption,
													$this->manageUsersService,
													$this->attributeService,
													$this->groupRepository,
													$this->groupViewRepository);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testBindsUsersAndAttributesAndGroups()
	{
		$userId = 123;
		$pageNumber = 1;
		$pageSize = 10;

		$result = new UserItemView();
		$result->Id = $userId;
		$results = array($result);
		$userList = new PageableData($results);

		$resourceList = array(new FakeBookableResource(1));

		$attributeList = array(new FakeCustomAttribute(1, '1'));

		$this->page
				->expects($this->once())
				->method('GetPageNumber')
				->will($this->returnValue($pageNumber));

		$this->page
				->expects($this->once())
				->method('GetPageSize')
				->will($this->returnValue($pageSize));

		$this->page
				->expects($this->once())
				->method('GetFilterStatusId')
				->will($this->returnValue(AccountStatus::ALL));

		$this->userRepo
				->expects($this->once())
				->method('GetList')
				->with($this->equalTo($pageNumber), $this->equalTo($pageSize), $this->isNull(), $this->isNull(),
					   $this->isNull(), $this->equalTo(AccountStatus::ALL))
				->will($this->returnValue($userList));

		$user = new FakeUser();

		$this->userRepo
				->expects($this->once())
				->method('LoadById')
				->with($this->fakeUser->UserId)
				->will($this->returnValue($user));

		$this->page
				->expects($this->once())
				->method('BindUsers')
				->with($this->equalTo($userList->Results()));

		$this->page
				->expects($this->once())
				->method('BindPageInfo')
				->with($this->equalTo($userList->PageInfo()));

		$this->resourceRepo
				->expects($this->once())
				->method('GetResourceList')
				->will($this->returnValue($resourceList));

		$this->page
				->expects($this->once())
				->method('BindResources')
				->with($this->equalTo($resourceList));


		$this->attributeService
				->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo(CustomAttributeCategory::USER))
				->will($this->returnValue($attributeList));

		$this->page
				->expects($this->once())
				->method('BindAttributeList')
				->with($this->equalTo($attributeList));

		$groups = array(new GroupItemView(1, 'gn'));
		$groupList = new PageableData($groups);
		$this->groupViewRepository
				->expects($this->once())
				->method('GetList')
				->will($this->returnValue($groupList));

		$this->page->expects($this->once())
					->method('BindGroups')
					->with($this->equalTo($groups));

		$this->presenter->PageLoad();
	}

	public function testGetsSelectedResourcesFromPageAndAssignsPermission()
	{
		$resourcesThatShouldRemainUnchanged = array(5, 10);
		$allowedResourceIds = array(1, 2, 4, 20, 30);
		$submittedResourceIds = array(1, 4);
		$currentResourceIds = array(1, 20, 30);

		$expectedResourceIds = array(1, 4, 5, 10);

		$allResourceIds = array_unique(array_merge($resourcesThatShouldRemainUnchanged, $allowedResourceIds, $submittedResourceIds, $currentResourceIds));

		$resources = array();
		foreach ($allResourceIds as $rid)
		{
			$resources[] = new FakeBookableResource($rid);
		}

		$userId = 9928;
		$adminUserId = $this->fakeUser->UserId;

		$user = new FakeUser();
		$user->WithPermissions(array_merge($resourcesThatShouldRemainUnchanged, $currentResourceIds));

		$adminUser = new FakeUser();
		$adminUser->_ResourceAdminResourceIds = $allowedResourceIds;
		$adminUser->_IsResourceAdmin = false;

		$this->page->expects($this->atLeastOnce())
				->method('GetUserId')
				->will($this->returnValue($userId));

		$this->page->expects($this->atLeastOnce())
				->method('GetAllowedResourceIds')
				->will($this->returnValue($submittedResourceIds));
		
		$this->resourceRepo->expects($this->once())
					->method('GetResourceList')
					->will($this->returnValue($resources));

		$this->userRepo->expects($this->at(0))
				->method('LoadById')
				->with($this->equalTo($adminUserId))
				->will($this->returnValue($adminUser));

		$this->userRepo->expects($this->at(1))
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$this->presenter->ChangePermissions();

		$actual = $user->AllowedResourceIds();
		$this->assertEquals(sort($expectedResourceIds), sort($actual));

	}

	public function testResetPasswordEncryptsAndUpdates()
	{
		$password = 'password';
		$salt = 'salt';
		$encrypted = 'encrypted';
		$userId = 123;

		$this->page->expects($this->atLeastOnce())
				->method('GetUserId')
				->will($this->returnValue($userId));

		$this->page->expects($this->once())
				->method('GetPassword')
				->will($this->returnValue($password));

		$this->encryption->expects($this->once())
				->method('Salt')
				->will($this->returnValue($salt));

		$this->encryption->expects($this->once())
				->method('Encrypt')
				->with($this->equalTo($password), $this->equalTo($salt))
				->will($this->returnValue($encrypted));

		$user = new User();

		$this->userRepo->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$this->presenter->ResetPassword();

		$this->assertEquals($encrypted, $user->encryptedPassword);
		$this->assertEquals($salt, $user->passwordSalt);
	}

	public function testCanUpdateUser()
	{
		$userId = 1029380;
		$fname = 'f';
		$lname = 'l';
		$username = 'un';
		$email = 'e@mail.com';
		$timezone = 'America/Chicago';
		$phone = '123-123-1234';
		$organization = 'ou';
		$position = 'position';

		$user = new FakeUser($userId);

		$this->page->expects($this->atLeastOnce())
				->method('GetUserId')
				->will($this->returnValue($userId));

		$this->page->expects($this->once())
				->method('GetFirstName')
				->will($this->returnValue($fname));

		$this->page->expects($this->once())
				->method('GetLastName')
				->will($this->returnValue($lname));

		$this->page->expects($this->once())
				->method('GetUserName')
				->will($this->returnValue($username));

		$this->page->expects($this->once())
				->method('GetEmail')
				->will($this->returnValue($email));

		$this->page->expects($this->once())
				->method('GetTimezone')
				->will($this->returnValue($timezone));

		$this->page->expects($this->once())
				->method('GetPhone')
				->will($this->returnValue($phone));

		$this->page->expects($this->once())
				->method('GetOrganization')
				->will($this->returnValue($organization));

		$this->page->expects($this->once())
				->method('GetPosition')
				->will($this->returnValue($position));

		$extraAttributes = array(
			UserAttribute::Organization => $organization,
			UserAttribute::Phone => $phone,
			UserAttribute::Position => $position);

		$this->manageUsersService->expects($this->once())
				->method('UpdateUser')
				->with($this->equalTo($userId),
					   $this->equalTo($username),
					   $this->equalTo($email),
					   $this->equalTo($fname),
					   $this->equalTo($lname),
					   $this->equalTo($timezone),
					   $this->equalTo($extraAttributes))
				->will($this->returnValue($user));

		$this->presenter->UpdateUser();
	}

	public function testDeletesUser()
	{
		$userId = 809;
		$this->page->expects($this->once())
				->method('GetUserId')
				->will($this->returnValue($userId));

		$this->manageUsersService->expects($this->once())
				->method('DeleteUser')
				->with($this->equalTo($userId));

		$this->presenter->DeleteUser();
	}

	public function testUpdatesAttributes()
	{
		$attributeId = 1;
		$attributeValue = 'value';
		$userId = 111;
		$attributeFormElements = array(new AttributeFormElement($attributeId, $attributeValue));

		$this->page
				->expects($this->once())
				->method('GetAttributes')
				->will($this->returnValue($attributeFormElements));

		$this->page
				->expects($this->once())
				->method('GetUserId')
				->will($this->returnValue($userId));

		$this->manageUsersService->expects($this->once())
				->method('ChangeAttributes')
				->with($this->equalTo($userId),
					   $this->equalTo(array(new AttributeValue($attributeId, $attributeValue))));

		$this->presenter->ChangeAttributes();
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
		$attributeFormElements = array(new AttributeFormElement($attributeId, $attributeValue));

		$userId = 1090;
		$groupId = 111;

		$user = new FakeUser($userId);

		$group = new Group($groupId, 'name');
		$group->AddUser($userId);

		$this->fakeConfig->SetKey(ConfigKeys::LANGUAGE, $lang);

		$this->page->expects($this->once())
				->method('GetFirstName')
				->will($this->returnValue($fname));

		$this->page->expects($this->once())
				->method('GetLastName')
				->will($this->returnValue($lname));

		$this->page->expects($this->once())
				->method('GetUserName')
				->will($this->returnValue($username));

		$this->page->expects($this->once())
				->method('GetEmail')
				->will($this->returnValue($email));

		$this->page->expects($this->once())
				->method('GetTimezone')
				->will($this->returnValue($timezone));

		$this->page->expects($this->once())
				->method('GetPassword')
				->will($this->returnValue($password));

		$this->page
				->expects($this->once())
				->method('GetAttributes')
				->will($this->returnValue($attributeFormElements));

		$this->page
				->expects($this->once())
				->method('GetUserGroup')
				->will($this->returnValue($groupId));

		$this->manageUsersService->expects($this->once())
				->method('AddUser')
				->with($this->equalTo($username),
					   $this->equalTo($email),
					   $this->equalTo($fname),
					   $this->equalTo($lname),
					   $this->equalTo($password),
					   $this->equalTo($timezone),
					   $this->equalTo($lang),
					   $this->equalTo(Pages::DEFAULT_HOMEPAGE_ID),
					   $this->equalTo(array()),
					   $this->equalTo(array(new AttributeValue($attributeId, $attributeValue))))
				->will($this->returnValue($user));

		$this->groupRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($groupId))
				->will($this->returnValue($group));

		$this->groupRepository->expects($this->once())
				->method('Update')
				->with($this->equalTo($group));

		$this->presenter->AddUser();
	}

	public function testGetsAllUsers()
	{
		$users = array(new UserDto(1, 'f', 'l', 'e'));

		$this->userRepo->expects($this->once())
					->method('GetAll')
					->will($this->returnValue($users));

		$this->page->expects($this->once())
					->method('SetJsonResponse')
					->with($this->equalTo($users));

		$this->presenter->ProcessDataRequest('all');
	}
}

?>