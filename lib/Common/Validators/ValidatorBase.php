<?php

abstract class ValidatorBase implements IValidator 
{
	protected $isValid = true;
	
	public function IsValid()
	{
		return $this->isValid;
	}
}
?>