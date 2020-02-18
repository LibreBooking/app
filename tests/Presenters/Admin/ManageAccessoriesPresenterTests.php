<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/ManageAccessoriesPage.php');

class ManageAccessoriesPresenterTests extends TestBase
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
			$this->accessoryRepository);
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testWhenInitializing()
	{
		$accessories = array();
		$resources = array();

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

?>