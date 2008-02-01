<?php
class RegexValidator implements IValidator
{
	public function __construct($value, $regex)
	{
		$this->_value = $value;
		$this->_regex = $regex;
	}
	
	public function IsValid()
	{
		if(preg_match($this->_regex, $this->_value))
		{
			return true;
		}
		return false;
	}
}
?>