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
		$customAttributeRequired = CustomAttribute::Create(null, 1, 1, null, true, null);
		$customAttributeNotRequired = CustomAttribute::Create(null, 1, 1, null, false, null);

		$this->assertFalse($customAttributeRequired->SatisifiesRequired(''));
		$this->assertFalse($customAttributeRequired->SatisifiesRequired(' '));
		$this->assertFalse($customAttributeRequired->SatisifiesRequired("\t"));
		$this->assertFalse($customAttributeRequired->SatisifiesRequired(null));

		$this->assertTrue($customAttributeRequired->SatisifiesRequired('  something  '));
		$this->assertTrue($customAttributeNotRequired->SatisifiesRequired(''));
		$this->assertTrue($customAttributeNotRequired->SatisifiesRequired('something'));
	}

	public function testChecksForRegexValues()
	{
		$regex = '/^\d+$/';

		$customAttributeRequired = CustomAttribute::Create(null, 1, 1, $regex, false, null);
		$customAttributeNotRequired = CustomAttribute::Create(null, 1, 1, null, false, null);

		$this->assertFalse($customAttributeRequired->SatisifiesConstraint(''));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint(' '));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint(null));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint('a1'));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint('1a'));

		$this->assertTrue($customAttributeRequired->SatisifiesConstraint('1'));
		$this->assertTrue($customAttributeRequired->SatisifiesConstraint('11'));

		$this->assertTrue($customAttributeNotRequired->SatisifiesConstraint('abc'));
		$this->assertTrue($customAttributeNotRequired->SatisifiesConstraint(''));
	}

	public function testChecksForPossibleValues()
	{
		$customAttributeRequired = CustomAttribute::Create(null, 1, 1, null, false, '1,abc,1abc3');
		$customAttributeNotRequired = CustomAttribute::Create(null, 1, 1, null, false, null);

		$this->assertFalse($customAttributeRequired->SatisifiesConstraint(''));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint(' '));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint(null));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint('2'));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint('abcd'));
		$this->assertFalse($customAttributeRequired->SatisifiesConstraint('ab'));

		$this->assertTrue($customAttributeRequired->SatisifiesConstraint('1'));
		$this->assertTrue($customAttributeRequired->SatisifiesConstraint('abc'));
		$this->assertTrue($customAttributeRequired->SatisifiesConstraint('1abc3'));

		$this->assertTrue($customAttributeNotRequired->SatisifiesConstraint(''));
		$this->assertTrue($customAttributeNotRequired->SatisifiesConstraint('something'));
	}

	public function testTrimsOffPossibleValueWhiteSpace()
	{
		$attribute = CustomAttribute::Create(null, 1, 1, null, false, '  1, abc    ,1abc3   ');

		$list = $attribute->PossibleValueList();

		$this->assertTrue(in_array('1', $list));
		$this->assertTrue(in_array('abc', $list));
		$this->assertTrue(in_array('1abc3', $list));
	}
}

?>