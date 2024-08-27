<?php

require_once(ROOT_DIR . 'Pages/Admin/ManageAccessoriesPage.php');

class ManageAccessoriesPresenterTest extends TestBase
{
    /**
     * @var IManageAccessoriesPage|PHPUnit_Framework_MockObject_MockObject
     */
    private $page;

    /**
     * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
     */
    public $resourceRepository;

    /**
     * @var IAccessoryRepository|PHPUnit_Framework_MockObject_MockObject
     */
    public $accessoryRepository;

    /**
     * @var ManageAccessoriesPresenter
     */
    private $presenter;

    public function setUp(): void
    {
        parent::setup();

        $this->page = $this->createMock('IManageAccessoriesPage');
        $this->resourceRepository = $this->createMock('IResourceRepository');
        $this->accessoryRepository = $this->createMock('IAccessoryRepository');

        $this->presenter = new ManageAccessoriesPresenter(
            $this->page,
            $this->resourceRepository,
            $this->accessoryRepository
        );
    }

    public function teardown(): void
    {
        parent::teardown();
    }

    public function testWhenInitializing()
    {
        $accessories = [];
        $resources = [];

        $this->resourceRepository->expects($this->once())
            ->method('GetAccessoryList')
            ->will($this->returnValue($accessories));

        $this->resourceRepository->expects($this->once())
            ->method('GetResourceList')
            ->will($this->returnValue($resources));

        $this->page->expects($this->once())
            ->method('BindAccessories')
            ->with($this->equalTo($accessories));

        $this->page->expects($this->once())
            ->method('BindResources')
            ->with($this->equalTo($resources));

        $this->presenter->PageLoad();
    }

    public function testWhenAdding()
    {
        $name = 'accessory';
        $quantity = 2;

        $expectedAccessory = Accessory::Create($name, $quantity);

        $this->page->expects($this->once())
                ->method('GetAccessoryName')
                ->will($this->returnValue($name));

        $this->page->expects($this->once())
                ->method('GetQuantityAvailable')
                ->will($this->returnValue($quantity));

        $this->accessoryRepository->expects($this->once())
            ->method('Add')
            ->with($this->equalTo($expectedAccessory));

        $this->presenter->AddAccessory();
    }

    public function testWhenEditing()
    {
        $id = 1982;
        $name = 'accessory';
        $quantity = 2;

        $currentAccessory = new Accessory($id, 'lskdjfl', 18181);
        $expectedAccessory = new Accessory($id, $name, $quantity);

        $this->page->expects($this->once())
                ->method('GetAccessoryId')
                ->will($this->returnValue($id));

        $this->page->expects($this->once())
                ->method('GetAccessoryName')
                ->will($this->returnValue($name));

        $this->page->expects($this->once())
                ->method('GetQuantityAvailable')
                ->will($this->returnValue($quantity));

        $this->accessoryRepository->expects($this->once())
            ->method('LoadById')
            ->with($this->equalTo($id))
            ->will($this->returnValue($currentAccessory));

        $this->accessoryRepository->expects($this->once())
            ->method('Update')
            ->with($this->equalTo($expectedAccessory));

        $this->presenter->ChangeAccessory();
    }

    public function testWhenDeleting()
    {
        $id = 1982;

        $this->page->expects($this->once())
                ->method('GetAccessoryId')
                ->will($this->returnValue($id));

        $this->accessoryRepository->expects($this->once())
            ->method('Delete')
            ->with($this->equalTo($id));

        $this->presenter->DeleteAccessory();
    }
}
