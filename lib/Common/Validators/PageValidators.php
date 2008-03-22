<?php
//require_once('IValidator.php');

class PageValdiators
{
	private $validators = array();
	
	public function Register($id, $validator)
	{
		$this->validators[$id] = $validator;
	}
	
	public function Get($id)
	{
		if (!array_key_exists($id, $this->validators))
		{
			return new NullValidator();
		}
		return $this->validators[$id];
	}
}

class NullValidator implements IValidator
{
	public function IsValid()
	{
		return true;
	}
}
?>