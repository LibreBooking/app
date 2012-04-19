<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ValidatorTests extends TestBase 
{	
	public function testValidatorsAreEvaluatedWhenRegistered()
	{
		$validator = new FakeValidator();
		$validator->_IsValid = true;
		$validators = new PageValidators(new SmartyPage());
		
		$validators->Register('someid', $validator);	
		$validators->Validate();
		
		$this->assertTrue($validator->_WasValidated, "should have been validated when registered");
		$this->assertTrue($validators->AreAllValid());
	}
	
	public function testPasswordComplexity()
	{
		$regex = '/^[^\s ]{6,}$/i';
		
		$valid1 = new RegexValidator('$password$_+123', $regex);
		$valid2 = new RegexValidator('pas123', $regex);
		
		$invalid1 = new RegexValidator('passw', $regex);
		$invalid2 = new RegexValidator('password123 123', $regex);
		$invalid3 = new RegexValidator('', $regex);
		
		$valid1->Validate();
		$valid2->Validate();
		$invalid1->Validate();
		$invalid2->Validate();
		$invalid3->Validate();
		
		$this->assertTrue($valid1->IsValid());
		$this->assertTrue($valid2->IsValid());
		$this->assertFalse($invalid1->IsValid());
		$this->assertFalse($invalid2->IsValid(), "spaces are not allowed");
		$this->assertFalse($invalid3->IsValid(), "password is required are not allowed");
	}
}
?>