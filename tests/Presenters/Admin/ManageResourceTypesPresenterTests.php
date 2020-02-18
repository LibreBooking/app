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

require_once(ROOT_DIR . 'Presenters/Admin/ManageResourceTypesPresenter.php');

class ManageResourceTypesPresenterTests extends TestBase
{
	/**
	 * @var ManageResourceTypesPresenter
	 */
	private $presenter;

	/**
	 * @var IManageResourceTypesPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	public function setUp(): void
	{
		parent::setup();

		$this->page = $this->createMock('IManageResourceTypesPage');
		$this->resourceRepository = $this->createMock('IResourceRepository');
		$this->attributeService = $this->createMock('IAttributeService');

		$this->presenter = new ManageResourceTypesPresenter($this->page, $this->fakeUser, $this->resourceRepository, $this->attributeService);
	}

	public function testBindsResourceTypes()
	{
		$types = array(new ResourceType(1, 'name', 'desc'));

		$attributes = $this->createMock('IEntityAttributeList');

		$this->resourceRepository
				->expects($this->once())
		->method('GetResourceTypes')
		->will($this->returnValue($types));

		$this->attributeService
				->expects($this->once())
		->method('GetByCategory')
		->with($this->equalTo(CustomAttributeCategory::RESOURCE_TYPE))
		->will($this->returnValue($attributes));

		$this->page
				->expects($this->once())
		->method('BindResourceTypes')
		->with($this->equalTo($types));

		$this->page
				->expects($this->once())
		->method('BindAttributeList')
		->with($this->equalTo($attributes));

		$this->presenter->PageLoad();
	}

	public function testAddsNewResourceType()
	{
		$name = 'name';
		$description = 'description';
		$this->page->expects($this->once())
		->method('GetResourceTypeName')
		->will($this->returnValue($name));

		$this->page->expects($this->once())
		->method('GetDescription')
		->will($this->returnValue($description));

		$type = ResourceType::CreateNew($name, $description);

		$this->resourceRepository
				->expects($this->once())
		->method('AddResourceType')
		->with($this->equalTo($type));

		$this->presenter->Add();
	}

	public function testUpdatesResourceType()
	{
		$id = 1232;
		$name = 'name';
		$description = 'description';

		$resourceType = new ResourceType($id, $name, $description);

		$this->page
				->expects($this->once())
		->method('GetId')
		->will($this->returnValue($id));

		$this->page
				->expects($this->once())
		->method('GetResourceTypeName')
		->will($this->returnValue($id));

		$this->page
				->expects($this->once())
		->method('GetDescription')
		->will($this->returnValue($id));

		$this->resourceRepository
				->expects($this->once())
		->method('LoadResourceType')
		->with($this->equalTo($id))
		->will($this->returnValue($resourceType));

		$this->resourceRepository
				->expects($this->once())
		->method('UpdateResourceType')
		->with($this->equalTo($resourceType));

		$this->presenter->Update();
	}

	public function testDeletesResourceType()
	{
		$id = 9919;

		$this->page
				->expects($this->once())
		->method('GetId')
		->will($this->returnValue($id));

		$this->resourceRepository
						->expects($this->once())
				->method('RemoveResourceType')
				->with($this->equalTo($id));

		$this->presenter->Delete();
	}
}