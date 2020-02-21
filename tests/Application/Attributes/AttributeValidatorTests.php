<?php
/**
Copyright 2012-2020 Nick Korbel

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

class AttributeValidatorTests extends TestBase
{
	public function testChecksAttributesAgainstService()
	{
		$service = $this->createMock('IAttributeService');
		$category = CustomAttributeCategory::RESOURCE;
		$attributes = array('abc');
		$entityId = 123;

		$errors = array('error1', 'error2');

		$serviceResult = new AttributeServiceValidationResult(false, $errors);

		$service->expects($this->once())
				->method('Validate')
				->with($this->equalTo($category), $this->equalTo($attributes), $this->equalTo($entityId))
				->will($this->returnValue($serviceResult));

		$validator = new AttributeValidator($service, $category, $attributes, $entityId);
		$validator->Validate();

		$this->assertFalse($validator->IsValid());
		$this->assertEquals($errors, $validator->Messages());

	}
}
?>