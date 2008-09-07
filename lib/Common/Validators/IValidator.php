<?php
interface IValidator
{
	/**
	 * @return bool
	 */
	public function IsValid();
	
	public function Validate();
}

?>