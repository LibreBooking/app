<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Admin/ManageResourceGroupsPresenter.php');

class ManageResourceGroupsPresenterTests extends TestBase
{
	/**
	 * @var ManageResourceGroupsPresenter
	 */
	private $presenter;

	/**
	 * @var IManageResourceGroupsPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;


	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageResourceGroupsPage');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->presenter = new ManageResourceGroupsPresenter($this->page, $this->fakeUser, $this->resourceRepository);
	}

	public function testBindsResourcesAndGroupsOnLoad()
	{
		$groupTree = new ResourceGroupTree();
		$resources = array();

		$this->resourceRepository
				->expects($this->once())
		->method('GetResourceGroups')
		->will($this->returnValue($groupTree));

		$this->resourceRepository
				->expects($this->once())
		->method('GetResourceList')
		->will($this->returnValue($resources));

		$this->page
				->expects($this->atLeastOnce())
		->method('BindResourceGroups')
		->with($this->equalTo($groupTree));

		$this->page
				->expects($this->atLeastOnce())
		->method('BindResources')
		->with($this->equalTo($resources));

		$this->presenter->PageLoad();
	}

	public function testAddsResourceToGroup()
	{
		$resourceId = 1;
		$groupId = 2;

		$this->page
				->expects($this->atLeastOnce())
		->method('GetResourceId')
		->will($this->returnValue($resourceId));

		$this->page
				->expects($this->atLeastOnce())
		->method('GetGroupId')
		->will($this->returnValue($groupId));

		$this->resourceRepository
				->expects($this->once())
		->method('AddResourceToGroup')
		->with($this->equalTo($resourceId), $this->equalTo($groupId));

		$this->presenter->AddResource();
	}

	public function testRemovesResourceFromGroup()
	{
		$resourceId = 1;
		$groupId = 2;

		$this->page
				->expects($this->atLeastOnce())
		->method('GetResourceId')
		->will($this->returnValue($resourceId));

		$this->page
				->expects($this->atLeastOnce())
		->method('GetGroupId')
		->will($this->returnValue($groupId));

		$this->resourceRepository
				->expects($this->once())
		->method('RemoveResourceFromGroup')
		->with($this->equalTo($resourceId), $this->equalTo($groupId));

		$this->presenter->RemoveResource();
	}
}

?>