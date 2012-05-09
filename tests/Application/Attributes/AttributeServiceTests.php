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

require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class AttributeServiceTests extends TestBase
{
	public function testGetsAttributeValuesForEntitiesInCategory()
	{
		$category = CustomAttributeCategory::RESERVATION;
		$entityIds = array(1,5,10,15,20);

		$attributes = array(new TestCustomAttribute(1, 'label1'), new TestCustomAttribute(2, 'label2'));
		$values = array(new AttributeEntityValue(1, 1, 'value1'), new AttributeEntityValue(2, 1, 'value2'));

		$attributeRepository = $this->getMock('IAttributeRepository');

		$attributeService = new AttributeService($attributeRepository);

		$attributeRepository->expects($this->once())
			->method('GetByCategory')
			->with($this->equalTo($category))
			->will($this->returnValue($attributes));

		$attributeRepository->expects($this->once())
			->method('GetEntityValues')
			->with($this->equalTo($category), $this->equalTo($entityIds))
			->will($this->returnValue($values));

		$attributeList = $attributeService->GetAttributes($category, $entityIds);

		$this->assertEquals(array('value1', 'value2'), $attributeList->GetValues(1));
		$this->assertEquals(array('label1', 'label2'), $attributeList->GetLabels());
	}

}

?>