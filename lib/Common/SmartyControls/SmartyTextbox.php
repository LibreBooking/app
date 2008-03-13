<?php

class SmartyTextbox
{
	private $name;
	private $class;
	private $smartyVariable;
	private $smarty;
	
	public function __construct($formKey, $class, $smartyVariable, &$smarty)
	{
		$this->name = $this->GetName($formKey);
		$this->class = $class;
		$this->smartyVariable = $smartyVariable;
		$this->smarty = $smarty;
	}
	
	public function Html()
	{
		$value = $this->GetValue();
		
		return "<input type=\"{$this->GetInputType()}\" class=\"{$this->class}\" name=\"{$this->name}\" id=\"{$this->name}\" value=\"$value\" />";
	}
	
	protected function GetInputType()
	{
		return 'text';
	}
	
	private function GetName($formKey)
	{
		return eval("return FormKeys::$formKey;");
	}
	
	private function GetValue()
	{
		$value = $this->GetPostedValue();

		if (empty($value))
		{
			$value = $this->GetTemplateValue();
		}
		
		return trim($value);
	}
	
	private function GetPostedValue()
	{
		return ServiceLocator::GetServer()->GetForm($this->name);
	}
	
	private function GetTemplateValue()
	{
		$value = '';
		
		$var = $this->smarty->get_template_vars($this->smartyVariable);
		if (!empty($var))
		{
			$value = $var;
		}
		
		return $value;
	}
}

class SmartyPasswordbox extends SmartyTextbox
{
	protected function GetInputType()
	{
		return 'password';
	}
}
?>