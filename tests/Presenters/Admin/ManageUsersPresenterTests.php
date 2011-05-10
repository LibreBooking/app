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

	public function setup()
	{
		parent::setup();
		
		$this->page = $this->getMock('IManageUsersPage');
		$this->userRepo = $this->getMock('UserRepository');
		$this->resourceRepo = $this->getMock('IResourceRepository');

		$this->presenter = new ManageUsersPresenter($this->page, $this->userRepo, $this->resourceRepo);
	}
	
	public function teardown()
	{
		parent::teardown();
	}

	public function testGetsSelectedResourcesFromPageAndAssignsPermission()
	{
		$resourceIds = array(1, 2, 4);

		$userId = 9928;
		
		$this->page->expects($this->once())
				->method('GetUserId')
				->will($this->returnValue($userId));
		
		$this->page->expects($this->once())
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
}
?>