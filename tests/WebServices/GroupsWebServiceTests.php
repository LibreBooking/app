<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/GroupsWebService.php');

class GroupsWebServiceTests extends TestBase
{
	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var GroupsWebService
	 */
	private $service;

	/**
	 * @var IGroupRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $groupRepository;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupViewRepository;

	public function setup()
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->groupRepository = $this->getMock('IGroupRepository');
		$this->groupViewRepository = $this->getMock('IGroupViewRepository');

		$this->service = new GroupsWebService($this->server, $this->groupRepository, $this->groupViewRepository);
	}

	public function testGetsAllGroups()
	{
		$groupId = 123232;
		$groupItemView = new GroupItemView($groupId, 'name');
		$groupItemView->Id = $groupId;

		$list = array($groupItemView);
		$groups = new PageableData($list);

		$this->groupViewRepository->expects($this->once())
				->method('GetList')
				->with($this->isNull(), $this->isNull())
				->will($this->returnValue($groups));

		$this->service->GetGroups();

		$expectedResponse = new GroupsResponse($this->server, $groups);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testGetsASingleGroup()
	{
		$groupId = 999;
		$group = new FakeGroup($groupId);

		$this->groupRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($groupId))
				->will($this->returnValue($group));

		$expectedResponse = new GroupResponse($this->server, $group);

		$this->service->GetGroup($groupId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testWhenGroupIsNotFound()
	{
		$groupId = 999;
		$this->groupRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($groupId))
				->will($this->returnValue(null));

		$expectedResponse = RestResponse::NotFound();

		$this->service->GetGroup($groupId);

		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
		$this->assertEquals(RestResponse::NOT_FOUND_CODE, $this->server->_LastResponseCode);
	}
}

?>