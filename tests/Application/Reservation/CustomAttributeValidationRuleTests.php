<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class CustomAttributeValidationRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testChecksEachAttributeInCategory()
	{
		$val1 = 'val1';
		$val2 = 'val2';
		$val3 = 'val2';

		$reservation = new TestReservationSeries();
		$reservation->WithAttributeValue(new AttributeValue(1, $val1));
		$reservation->WithAttributeValue(new AttributeValue(2, $val2));
		$reservation->WithAttributeValue(new AttributeValue(3, $val3));

		$attributeRepository = $this->getMock('IAttributeRepository');

		$fakeAttr1 = new FakeCustomAttribute(1, false, true);
		$fakeAttr2 = new FakeCustomAttribute(2, true, false);
		$fakeAttr3 = new FakeCustomAttribute(3, true, true);

		$customAttributes = array($fakeAttr1, $fakeAttr2, $fakeAttr3);

		$attributeRepository->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION))
				->will($this->returnValue($customAttributes));

		$rule = new CustomAttributeValidationRule($attributeRepository);
		$result = $rule->Validate($reservation);

		$this->assertEquals(false, $result->IsValid());

		$this->assertContains($fakeAttr1->Label(), $result->ErrorMessage());
		$this->assertContains($fakeAttr2->Label(), $result->ErrorMessage());
		$this->assertNotContains($fakeAttr3->Label(), $result->ErrorMessage());

		$this->assertEquals($val1, $fakeAttr1->_RequiredValueChecked);
		$this->assertEquals($val2, $fakeAttr2->_RequiredValueChecked);
		$this->assertEquals($val3, $fakeAttr3->_RequiredValueChecked);

		$this->assertEquals($val1, $fakeAttr1->_ConstraintValueChecked);
		$this->assertEquals($val2, $fakeAttr2->_ConstraintValueChecked);
		$this->assertEquals($val3, $fakeAttr3->_ConstraintValueChecked);
	}

	public function testWhenAllAttributesAreValid()
	{
		$reservation = new TestReservationSeries();
		$reservation->WithAttributeValue(new AttributeValue(1, null));
		$reservation->WithAttributeValue(new AttributeValue(2, null));
		$reservation->WithAttributeValue(new AttributeValue(3, null));

		$attributeRepository = $this->getMock('IAttributeRepository');

		$fakeAttr1 = new FakeCustomAttribute(1, true, true);
		$fakeAttr2 = new FakeCustomAttribute(2, true, true);
		$fakeAttr3 = new FakeCustomAttribute(3, true, true);

		$customAttributes = array($fakeAttr1, $fakeAttr2, $fakeAttr3);

		$attributeRepository->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION))
				->will($this->returnValue($customAttributes));

		$rule = new CustomAttributeValidationRule($attributeRepository);
		$result = $rule->Validate($reservation);

		$this->assertEquals(true, $result->IsValid());
	}
}


?>