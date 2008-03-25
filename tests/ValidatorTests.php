<?php
require_once($root . 'lib/Common/namespace.php');

class ValidatorTests extends TestBase 
{	
	public function testValidatorsAreEvaluatedWhenRegistered()
	{
		$validator = new FakeValidator();
		$validator->_IsValid = true;
		$validators = new PageValdiators();
		
		$validators->Register('someid', $validator);	
		$validators->Validate();
		
		$this->assertTrue($validator->_WasValidated, "should have been validated when registered");
		$this->assertTrue($validators->AreAllValid());
	}
	
}
?>