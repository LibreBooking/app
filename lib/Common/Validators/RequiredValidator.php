<?php

class RequiredValidator extends ValidatorBase implements IValidator 
{
	private $value;
	
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	public function Validate()
	{
		$this->isValid = !empty($this->value);
	}
}
?>