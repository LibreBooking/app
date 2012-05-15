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

require_once(ROOT_DIR . 'Domain/namespace.php');

class CustomAttributeTests extends TestBase
{
	public function testChecksForRequiredValues()
	{
		$customAttributeRequired = CustomAttribute::Create(null, 1, 1, null, true, null, null);
		$customAttributeNotRequired = CustomAttribute::Create(null, 1, 1, null, false, null, null);

		$this->assertFalse($customAttributeRequired->SatisfiesRequired(''));
		$this->assertFalse($customAttributeRequired->SatisfiesRequired(' '));
		$this->assertFalse($customAttributeRequired->SatisfiesRequired("\t"));
		$this->assertFalse($customAttributeRequired->SatisfiesRequired(null));

		$this->assertTrue($customAttributeRequired->SatisfiesRequired('  something  '));
		$this->assertTrue($customAttributeNotRequired->SatisfiesRequired(''));
		$this->assertTrue($customAttributeNotRequired->SatisfiesRequired('something'));
	}

	public function testChecksForRegexValues()
	{
		$regex = '/^\d+$/';

		$customAttributeRequired = CustomAttribute::Create(null, 1, 1, $regex, false, null, null);
		$customAttributeNotRequired = CustomAttribute::Create(null, 1, 1, null, false, null, null);

		$this->assertFalse($customAttributeRequired->SatisfiesConstraint(''));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint(' '));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint(null));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint('a1'));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint('1a'));

		$this->assertTrue($customAttributeRequired->SatisfiesConstraint('1'));
		$this->assertTrue($customAttributeRequired->SatisfiesConstraint('11'));

		$this->assertTrue($customAttributeNotRequired->SatisfiesConstraint('abc'));
		$this->assertTrue($customAttributeNotRequired->SatisfiesConstraint(''));
	}

	public function testChecksForPossibleValues()
	{
		$customAttributeRequired = CustomAttribute::Create(null, 1, 1, null, false, '1,abc,1abc3', null);
		$customAttributeNotRequired = CustomAttribute::Create(null, 1, 1, null, false, null, null);

		$this->assertFalse($customAttributeRequired->SatisfiesConstraint(''));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint(' '));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint(null));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint('2'));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint('abcd'));
		$this->assertFalse($customAttributeRequired->SatisfiesConstraint('ab'));

		$this->assertTrue($customAttributeRequired->SatisfiesConstraint('1'));
		$this->assertTrue($customAttributeRequired->SatisfiesConstraint('abc'));
		$this->assertTrue($customAttributeRequired->SatisfiesConstraint('1abc3'));

		$this->assertTrue($customAttributeNotRequired->SatisfiesConstraint(''));
		$this->assertTrue($customAttributeNotRequired->SatisfiesConstraint('something'));
	}

	public function testTrimsOffPossibleValueWhiteSpace()
	{
		$attribute = CustomAttribute::Create(null, 1, 1, null, false, '  1, abc    ,1abc3   ', '    1   ');

		$list = $attribute->PossibleValueList();

		$this->assertTrue(in_array('1', $list));
		$this->assertTrue(in_array('abc', $list));
		$this->assertTrue(in_array('1abc3', $list));
		$this->assertEquals(1, $attribute->SortOrder());
	}
}

?>