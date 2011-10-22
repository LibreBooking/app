<?php

abstract class ValidatorBase implements IValidator
{
	protected $isValid = true;

	/**
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->isValid;
	}
}
?>