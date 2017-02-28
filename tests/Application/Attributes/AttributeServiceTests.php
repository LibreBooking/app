<?php
/**
Copyright 2012-2017 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class AttributeServiceTests extends TestBase
{
	/**
	 * @var AttributeService
	 */
	public $attributeService;

	/**
	 * @var FakeAttributeRepository
	 */
	public $attributeRepository;

	/**
	 * @var FakeAuthorizationService
	 */
	public $authorizationService;

	/**
	 * @var FakeResourceService
	 */
	public $resourceService;

	public function setup()
	{
		parent::setup();

//		$this->attributeRepository = $this->getMock('IAttributeRepository');

		$this->attributeRepository = new FakeAttributeRepository();
		$this->authorizationService = new FakeAuthorizationService();
		$this->resourceService = new FakeResourceService();

		$this->attributeService = new AttributeService($this->attributeRepository);
		$this->attributeService->SetAuthorizationService($this->authorizationService);
		$this->attributeService->SetResourceService($this->resourceService);
	}

	public function testGetsAttributeValuesForEntitiesInCategory()
	{
		$category = CustomAttributeCategory::RESERVATION;
		$entityIds = array(1, 5, 10, 15, 20);

		$attributes = array(
			new TestCustomAttribute(1, 'label1'),
			new TestCustomAttribute(2, 'label2'),
			new TestCustomAttribute(3, 'label3', 1),
			new TestCustomAttribute(4, 'label4', 20),
			new TestCustomAttribute(5, 'label5', 99),
			new TestCustomAttribute(6, 'label6', 1),
		);

		$values = array(
			new AttributeEntityValue(1, 1, 'value1'),
			new AttributeEntityValue(2, 1, 'value2'),
			new AttributeEntityValue(3, 1, 'value3'),
			new AttributeEntityValue(4, 20, 'value20'),
		);

		$this->attributeRepository->_CustomAttributes = $attributes;
		$this->attributeRepository->_EntityValues = $values;
		$attributeList = $this->attributeService->GetAttributes($category, $entityIds);

		$this->assertEquals(array(
								new Attribute($attributes[0], 'value1'),
								new Attribute($attributes[1], 'value2'),
								new Attribute($attributes[2], 'value3'),
								new Attribute($attributes[5], null),
							), $attributeList->GetAttributes(1));
		$this->assertEquals(array(new Attribute($attributes[0], null), new Attribute($attributes[1], null), new Attribute($attributes[3], 'value20')), $attributeList->GetAttributes(20));
		$this->assertEquals(array('label1', 'label2', 'label3', 'label4', 'label5', 'label6'), $attributeList->GetLabels());
	}

	public function testValidatesValuesAgainstDefinitions()
	{
		$entityId = 4;
		$category = CustomAttributeCategory::RESERVATION;

		$attributes = array(
			new FakeCustomAttribute(1, true, false),
			new FakeCustomAttribute(2, false, true),
			new FakeCustomAttribute(3, true, false, $entityId),
			new FakeCustomAttribute(4, false, false, 5));

		$values = array(
			new AttributeValue(1, 'value1'),
			new AttributeValue(2, 'value2'),
			new AttributeValue(3, 'value2'),
		);

		$this->attributeRepository->_CustomAttributes = $attributes;
		$this->attributeRepository->_EntityValues = $values;

		$result = $this->attributeService->Validate($category, $values, $entityId);

		$this->assertFalse($result->IsValid());
		$this->assertEquals(3, count($result->Errors()));
	}

	public function testWhenUserIsNotAdminButAttributeIsAdminOnly_ThenDoNotValidate()
	{
		$category = CustomAttributeCategory::RESERVATION;
		$isAdmin = false;

		$attributes = array(new FakeCustomAttribute(1, true, false, null, true));
		$values = array(new AttributeValue(1, 'value1'));

		$this->attributeRepository->_CustomAttributes = $attributes;
		$this->attributeRepository->_EntityValues = $values;

		$result = $this->attributeService->Validate($category, $values, null, false, $isAdmin);

		$this->assertTrue($result->IsValid());
	}

	public function testWhenUserIsAdminAndAttributeIsAdminOnly_ThenValidate()
	{
		$category = CustomAttributeCategory::RESERVATION;
		$isAdmin = true;

		$attributes = array(new FakeCustomAttribute(1, true, false, null, true));
		$values = array(new AttributeValue(1, 'value1'));

		$this->attributeRepository->_CustomAttributes = $attributes;
		$this->attributeRepository->_EntityValues = $values;

		$result = $this->attributeService->Validate($category, $values, null, false, $isAdmin);

		$this->assertFalse($result->IsValid());
	}

	public function testGetsAttributesForReservationUserAndResources()
	{
		$this->authorizationService->_CanReserveFor = false;
		$this->fakeUser->IsAdmin = false;
		$requestedUserId = 1;
		$resourceId1 = 10;
		$resourceId2 = 20;
		$resourceId3 = 30;

		$resourceTypeId1 = 100;
		$resourceTypeId2 = 200;

		$resource1 = new TestResourceDto($resourceId1);
		$resource2 = new TestResourceDto($resourceId2);
		$resource3 = new TestResourceDto($resourceId3, null, true, null, null, $resourceTypeId1);

		$this->resourceService->_AllResources = array($resource1, $resource3);

		$unrestricted = new CustomAttribute(1, 'unrestricted', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);

		$forUser = new CustomAttribute(2, 'forUser', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$forUser->WithSecondaryEntities(CustomAttributeCategory::USER, $requestedUserId);

		$notForUser = new CustomAttribute(3, 'notForUser', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$notForUser->WithSecondaryEntities(CustomAttributeCategory::USER, 100);

		$forResource1 = new CustomAttribute(4, 'forResource1', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$forResource1->WithSecondaryEntities(CustomAttributeCategory::RESOURCE, $resourceId1);

		$resource2IsNotAllowed = new CustomAttribute(5, 'forResource2', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$resource2IsNotAllowed->WithSecondaryEntities(CustomAttributeCategory::RESOURCE, $resourceId2);

		$forOtherResource = new CustomAttribute(6, 'forOtherResource', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$forOtherResource->WithSecondaryEntities(CustomAttributeCategory::RESOURCE, 300);

		$forResourceType1 = new CustomAttribute(7, 'forResourceType1', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$forResourceType1->WithSecondaryEntities(CustomAttributeCategory::RESOURCE_TYPE, $resourceTypeId1);

		$forOtherResourceType = new CustomAttribute(8, 'forResourceType2', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::RESERVATION, null, null, null, 0);
		$forOtherResourceType->WithSecondaryEntities(CustomAttributeCategory::RESOURCE_TYPE, $resourceTypeId2);

		$this->attributeRepository->_CustomAttributes = array($unrestricted, $forUser, $notForUser, $forResource1, $resource2IsNotAllowed, $forOtherResource, $forResourceType1, $forOtherResourceType);

		/** @var Attribute[] $attributes */
		$attributes = $this->attributeService->GetReservationAttributes($this->fakeUser, new ReservationView(), $requestedUserId, array($resourceId1, $resourceId2, $resourceId3));

		$this->assertEquals(4, count($attributes));
		$this->assertEquals($unrestricted->Id(), $attributes[0]->Id());
		$this->assertEquals($forUser->Id(), $attributes[1]->Id());
		$this->assertEquals($forResource1->Id(), $attributes[2]->Id());
		$this->assertEquals($forResourceType1->Id(), $attributes[3]->Id());
	}
}