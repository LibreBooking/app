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


	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageResourceTypesPage');
		$this->resourceRepository = $this->getMock('IResourceRepository');

		$this->presenter = new ManageResourceTypesPresenter($this->page, $this->fakeUser, $this->resourceRepository);
	}

	public function testBindsResourceTypes()
	{
		$types = array(new ResourceType(1,'name', 'desc'));

		$this->resourceRepository->expects($this->once())
					->method('GetResourceTypes')
					->will($this->returnValue($types));

		$this->page->expects($this->once())
					->method('BindResourceTypes')
					->with($this->equalTo($types));

		$this->presenter->PageLoad();
	}
}

?>