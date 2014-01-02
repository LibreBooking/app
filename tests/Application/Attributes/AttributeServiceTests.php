<?php
/**
Copyright 2012-2014 Nick Korbel

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
	 * @var IAttributeRepository
	 */
	public $attributeRepository;

	public function setup()
	{
		parent::setup();

		$this->attributeRepository = $this->getMock('IAttributeRepository');

		$this->attributeService = new AttributeService($this->attributeRepository);
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

		$this->attributeRepository->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo($category))
				->will($this->returnValue($attributes));

		$this->attributeRepository->expects($this->once())
				->method('GetEntityValues')
				->with($this->equalTo($category), $this->equalTo($entityIds))
				->will($this->returnValue($values));

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

		$this->attributeRepository->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo($category))
				->will($this->returnValue($attributes));

		$result = $this->attributeService->Validate($category, $values, $entityId);

		$this->assertFalse($result->IsValid());
		$this->assertEquals(3, count($result->Errors()));
	}

	public function testPassThroughForCategory()
	{
		$categoryId = 123;

		$this->attributeRepository->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo($categoryId))
				->will($this->returnValue(array()));

		$this->attributeService->GetByCategory($categoryId);
	}

	public function testPassThroughForAttribute()
	{
		$attributeId = 123;

		$this->attributeRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($attributeId))
				->will($this->returnValue(new TestCustomAttribute(1, 'l')));

		$this->attributeService->GetById($attributeId);
	}
}

?>