<?php

abstract class ValidatorBase implements IValidator 
{
	protected $isValid = false;
	
	public function IsValid()
	{
		return $this->isValid;
	}
}
?>