<?php
/**
Copyright 2013-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class ScheduleResourceFilterTests extends TestBase
{
	/**
	 * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	public function setup()
	{
		$this->resourceRepository = $this->getMock('IResourceRepository');
		$this->attributeService = $this->getMock('IAttributeService');

		parent::setup();
	}

	public function testReturnsAllWhenNoFilter()
	{
		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource4 = new FakeBookableResource(4, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$filter = new ScheduleResourceFilter();
		$resourceIds = $filter->FilterResources($resources, $this->resourceRepository, $this->attributeService);

		$this->assertEquals(count($resources), count($resourceIds));
	}

	public function testFiltersByResourceId()
	{
		$resourceId = 10;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource4 = new FakeBookableResource($resourceId, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$filter = new ScheduleResourceFilter();
		$filter->ResourceIds = array($resourceId);

		$resourceIds = $filter->FilterResources($resources, $this->resourceRepository, $this->attributeService);

		$this->assertEquals(1, count($resourceIds));
		$this->assertEquals($resourceId, $resourceIds[0]);
	}

	public function testFiltersByMinCapacity()
	{
		$minCapacity = 10;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource1->SetMaxParticipants($minCapacity);

		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource2->SetMaxParticipants($minCapacity - 1);

		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource3->SetMaxParticipants($minCapacity + 1);

		$resources = array($resource1, $resource2, $resource3);

		$filter = new ScheduleResourceFilter();
		$filter->MinCapacity = $minCapacity;

		$resourceIds = $filter->FilterResources($resources, $this->resourceRepository, $this->attributeService);

		$this->assertEquals(2, count($resourceIds));
		$this->assertEquals(1, $resourceIds[0]);
		$this->assertEquals(3, $resourceIds[1]);
	}

	public function testFiltersByResourceType()
	{
		$resourceTypeId = 4;

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource1->SetResourceTypeId($resourceTypeId);

		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource2->SetResourceTypeId(null);

		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource3->SetResourceTypeId(10);

		$resources = array($resource1, $resource2, $resource3);

		$filter = new ScheduleResourceFilter();
		$filter->ResourceTypeId = $resourceTypeId;

		$resourceIds = $filter->FilterResources($resources, $this->resourceRepository, $this->attributeService);

		$this->assertEquals(1, count($resourceIds));
		$this->assertEquals(1, $resourceIds[0]);
	}

	public function testFiltersResourceCustomAttributes()
	{
		$attributeId1 = 1;
		$attributeValue1 = 1;

		$attributeId2 = 2;
		$attributeValue2 = 'something';

		$resourceId = 4;

		$attributeList = new FakeAttributeList();
		$attributeList->Add($resourceId, new Attribute(new CustomAttribute($attributeId1, '', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, $resourceId), $attributeValue1));
		$attributeList->Add($resourceId, new Attribute(new CustomAttribute($attributeId2, '', CustomAttributeTypes::MULTI_LINE_TEXTBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, $resourceId), $attributeValue2));
		$attributeList->Add(1, new Attribute(new CustomAttribute($attributeId2, '', CustomAttributeTypes::MULTI_LINE_TEXTBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, 1), $attributeValue2));
		$attributeList->Add(3, new Attribute(new CustomAttribute($attributeId2, '', CustomAttributeTypes::MULTI_LINE_TEXTBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, 3), $attributeValue2));

		$this->attributeService->expects($this->once())
		->method('GetAttributes')
		->with($this->equalTo(CustomAttributeCategory::RESOURCE), $this->isNull())
		->will($this->returnValue($attributeList));

		$filter = new ScheduleResourceFilter();
		$filter->ResourceAttributes = array(
			new AttributeValue($attributeId1, $attributeValue1),
			new AttributeValue($attributeId2, $attributeValue2),
		);

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource3 = new FakeBookableResource(3, 'resource3');
		$resource4 = new FakeBookableResource($resourceId, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$resourceIds = $filter->FilterResources($resources, $this->resourceRepository, $this->attributeService);

		$this->assertEquals(1, count($resourceIds));
		$this->assertEquals($resourceId, $resourceIds[0]);
	}

	public function testFiltersResourceTypeCustomAttributes()
	{
		$attributeId1 = 1;
		$attributeValue1 = 1;

		$attributeId2 = 2;
		$attributeValue2 = 'something';

		$resourceId = 3;
		$resourceTypeId = 4;

		$attributeList = new FakeAttributeList();
		$attributeList->Add($resourceTypeId, new Attribute(new CustomAttribute($attributeId1, '', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, $resourceTypeId), $attributeValue1));
		$attributeList->Add($resourceTypeId, new Attribute(new CustomAttribute($attributeId2, '', CustomAttributeTypes::MULTI_LINE_TEXTBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, $resourceTypeId), $attributeValue2));
		$attributeList->Add(1, new Attribute(new CustomAttribute($attributeId2, '', CustomAttributeTypes::MULTI_LINE_TEXTBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, 1), $attributeValue2));
		$attributeList->Add(3, new Attribute(new CustomAttribute($attributeId2, '', CustomAttributeTypes::MULTI_LINE_TEXTBOX, CustomAttributeCategory::RESOURCE, '', false, '', 0, 3), $attributeValue2));

		$this->attributeService->expects($this->once())
		->method('GetAttributes')
		->with($this->equalTo(CustomAttributeCategory::RESOURCE_TYPE), $this->isNull())
		->will($this->returnValue($attributeList));

		$filter = new ScheduleResourceFilter();
		$filter->ResourceTypeAttributes = array(
			new AttributeValue($attributeId1, $attributeValue1),
			new AttributeValue($attributeId2, $attributeValue2),
		);

		$resource1 = new FakeBookableResource(1, 'resource1');
		$resource1->SetResourceTypeId(100);
		$resource2 = new FakeBookableResource(2, 'resource2');
		$resource2->SetResourceTypeId(200);
		$resource3 = new FakeBookableResource($resourceId, 'resource3');
		$resource3->SetResourceTypeId($resourceTypeId);
		$resource4 = new FakeBookableResource(4, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$resourceIds = $filter->FilterResources($resources, $this->resourceRepository, $this->attributeService);

		$this->assertEquals(1, count($resourceIds));
		$this->assertEquals($resourceId, $resourceIds[0]);
	}

}

?>