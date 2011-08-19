<?php
class Parameter
{
	/**
	 * @var string
	 */
	public $Name = null;

	/**
	 * @var mixed
	 */
	public $Value = null;
	
	public function __construct($name = null, $value = null) 
	{
		$this->Name = $name;
		$this->Value = $value;
	}
}
?>