<?php
interface IValidator
{
	/**
	 * @return bool
	 */
	public function IsValid();

	/**
	 * @abstract invoke the validation method
	 * @return void
	 */
	public function Validate();
}

?>