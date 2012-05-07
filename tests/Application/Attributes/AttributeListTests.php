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

class AttributeListTests extends TestBase
{
	public function testCanGetLabelsOfAllAttributes()
	{
		$attribute1 = new TestCustomAttribute(1, 'a1');
		$attribute2 = new TestCustomAttribute(2, 'a2');
		$attribute3 = new TestCustomAttribute(3, 'a3');

		$list = new AttributeList();
		$list->AddDefinition($attribute1);
		$list->AddDefinition($attribute2);
		$list->AddDefinition($attribute3);

		$labels = $list->GetLabels();

		$this->assertEquals(array('a1', 'a2', 'a3'), $labels);
	}

	public function testGetsValuesForEntity()
	{
		$entityId = 400;
		$attribute1 = new TestCustomAttribute(1, 'a1');
		$attribute2 = new TestCustomAttribute(2, 'a2');
		$attribute3 = new TestCustomAttribute(3, 'a3');

		$value1 = new AttributeEntityValue(1, $entityId, 'att1');
		$value3 = new AttributeEntityValue(3, $entityId, 'att3');
		$value4 = new AttributeEntityValue(4, $entityId, 'att2');

		$list = new AttributeList();
		$list->AddDefinition($attribute1);
		$list->AddDefinition($attribute2);
		$list->AddDefinition($attribute3);
		$list->AddValue($value1);
		$list->AddValue($value3);
		$list->AddValue($value4);


		$values = $list->GetValues($entityId);

		$this->assertEquals(array('att1', null, 'att3'), $values);
	}
}

class TestCustomAttribute extends CustomAttribute
{
	public function __construct($id, $label)
	{
		$this->id = $id;
		$this->label = $label;
	}
}
?>