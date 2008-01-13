<?php
require_once('IValidator.php');

class RequiredValidator implements IValidator
{
	private $value;
	
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	public function IsValid()
	{
		return !empty($this->value);
	}
}
?>