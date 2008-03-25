<?php

class PageValdiators
{
	private $validators = array();
	private $isValidated = false;
	
	public function Register($id, $validator)
	{
		$this->validators[$id] = $validator;
	}
	
	public function Validate()
	{
		foreach($this->validators as $validator)
		{
			$validator->Validate();
		}
		
		$this->_isValidated = true;
	}
	
	public function AreAllValid()
	{
		
		if (!$this->isValidated)
		{
			$this->Validate();
		}
		
		foreach($this->validators as $validator)
		{
			if (!$validator->IsValid())
			{
				return false;
			}
		}
		
		return true;
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

class NullValidator extends ValidatorBase implements IValidator 
{
	public function Validate()
	{
		$this->isValid = true;
	}
}
?>