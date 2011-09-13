<?php
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
	 * @var ManageUsersPresenter|PHPUnit_Framework_MockObject_MockObject
	 */
	public $presenter;

	/**
	 * @var PasswordEncryption
	 */
	public $encryption;

	public function setup()
	{
		parent::setup();
		
		$this->page = $this->getMock('IManageUsersPage');
		$this->userRepo = $this->getMock('UserRepository');
		$this->resourceRepo = $this->getMock('IResourceRepository');
		$this->encryption = $this->getMock('PasswordEncryption');

		$this->presenter = new ManageUsersPresenter($this->page, $this->userRepo, $this->resourceRepo, $this->encryption);
	}
	
	public function teardown()
	{
		parent::teardown();
	}

	public function testGetsSelectedResourcesFromPageAndAssignsPermission()
	{
		$resourceIds = array(1, 2, 4);

		$userId = 9928;
		
		$this->page->expects($this->atLeastOnce())
				->method('GetUserId')
				->will($this->returnValue($userId));
		
		$this->page->expects($this->atLeastOnce())
				->method('GetAllowedResourceIds')
				->will($this->returnValue($resourceIds));

		$user = new User();
		
		$this->userRepo->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($userId))
				->will($this->returnValue($user));

		$this->userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));

		$this->presenter->ChangePermissions();

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

		$this->assertEquals($encrypted, $user->password);
		$this->assertEquals($salt, $user->passwordSalt);
	}

	public function testCanUpdateUser()
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


		$this->userRepo->expects($this->once())
			->method('LoadById')
			->with($this->equalTo($userId))
			->will($this->returnValue($user));

		$this->userRepo->expects($this->once())
				->method('Update')
				->with($this->equalTo($user));
		
		$this->presenter->UpdateUser();

		$this->assertEquals($fname, $user->FirstName());
		$this->assertEquals($lname, $user->LastName());
		$this->assertEquals($timezone, $user->Timezone());

		$this->assertEquals($username, $user->Username());
		$this->assertEquals($email, $user->EmailAddress());
		$this->assertEquals($phone, $user->GetAttribute(UserAttribute::Phone));
		$this->assertEquals($organization, $user->GetAttribute(UserAttribute::Organization));
		$this->assertEquals($position, $user->GetAttribute(UserAttribute::Position));
	}

	public function testDeleteDelegatesToRepository()
	{
		$userId = 809;
		$this->page->expects($this->once())
				->method('GetUserId')
				->will($this->returnValue($userId));

		$this->userRepo->expects($this->once())
				->method('DeleteById')
				->with($this->equalTo($userId));
		
		$this->presenter->DeleteUser();
	}
}
?>