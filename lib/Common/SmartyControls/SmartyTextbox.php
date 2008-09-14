<?php

class SmartyTextbox
{
	private $name;
	private $class;
	private $smartyVariable;
	private $smarty;
	private $style;
	
	public function __construct($formKey, $class, $smartyVariable, $style, &$smarty)
	{
		$this->name = $this->GetName($formKey);
		$this->class = $class;
		$this->smartyVariable = $smartyVariable;
		$this->style = $style;
		$this->smarty = $smarty;
	}
	
	public function Html()
	{
		$value = $this->GetValue();
		$style = empty($this->style) ? '' : " style=\"{$this->style}\"";
		
		return "<input type=\"{$this->GetInputType()}\" class=\"{$this->class}\" name=\"{$this->name}\" id=\"{$this->name}\" value=\"$value\"$style />";
	}
	
	protected function GetInputType()
	{
		return 'text';
	}
	
	private function GetName($formKey)
	{
		return FormKeys::Evaluate($formKey);
	}
	
	private function GetValue()
	{
		$value = $this->GetPostedValue();

		if (empty($value))
		{
			$value = $this->GetTemplateValue();
		}
		
		if (!empty($value))
		{
			return trim($value);
		}
		
		return '';
	}
	
	private function GetPostedValue()
	{
		return ServiceLocator::GetServer()->GetForm($this->name);
	}
	
	private function GetTemplateValue()
	{
		$value = '';
		
		if (!empty($this->smartyVariable))
		{
			$var = $this->smarty->get_template_vars($this->smartyVariable);
			if (!empty($var))
			{
				$value = $var;
			}
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