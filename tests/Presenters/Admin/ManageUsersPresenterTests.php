<?php
require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');

class ManageUsersPresenterTests extends TestBase
{
	/**
	 * @var IManageUsersPage
	 */
	private $page;

	/**
	 * @var UserRepository
	 */
	public $userRepo;

	/**
	 * @var IResourceRepository
	 */
	public $resourceRepo;

	/**
	 * @var ManageUsersPresenter
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
}
?>