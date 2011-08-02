<?php
require_once(ROOT_DIR . 'Pages/Admin/ManageQuotasPage.php');

class ManageQuotasPresenterTests extends TestBase
{
	/**
	 * @var IManageQuotasPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var ManageQuotasPresenter
	 */
	private $presenter;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $resourceRepository;

	/**
	 * @var IGroupViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $groupRepository;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageQuotasPage');
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->groupRepository = $this->getMock('IGroupViewRepository');

		$this->presenter = new ManageQuotasPresenter($this->page, $this->resourceRepository, $this->groupRepository);
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenInitializing()
	{
		$groups = array();
		$bookableResources = array();
		$groupResult = new PageableData($groups);
		
		$this->resourceRepository->expects($this->once())
			->method('GetResourceList')
			->will($this->returnValue($bookableResources));

		$this->page->expects($this->once())
			->method('BindResources')
			->with($this->equalTo($bookableResources));

		$this->groupRepository->expects($this->once())
			->method('GetList')
			->will($this->returnValue($groupResult));

		$this->page->expects($this->once())
			->method('BindGroups')
			->with($this->equalTo($groups));

		$this->presenter->PageLoad();
	}
}

?>
