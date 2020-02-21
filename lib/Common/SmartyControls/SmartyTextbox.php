<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/


class SmartyTextbox
{
	private $name;
	private $type;
    private $id;
	private $attributes;
	private $smartyVariable;
	private $smarty;
    private $required;

    public function __construct($formKey, $type, $id, $smartyVariable, $attributes, $required, &$smarty)
	{
		$this->name = $this->GetName($formKey);
		$this->type = empty($type) ? 'text' : $type;
        $this->id = empty($id) ? $this->GetName($formKey) : $id;
		$this->attributes = $attributes;
		$this->smartyVariable = $smartyVariable;
		$this->required = $required;
		$this->smarty = $smarty;
	}

	public function Html()
	{
		$value = $this->GetValue();
		$style = empty($this->style) ? '' : " style=\"{$this->style}\"";
		$required = $this->required ? ' required="required" ' : '';

		return "<input type=\"{$this->GetInputType()}\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"$value\"{$required} $this->attributes />";
	}

	protected function GetInputType()
	{
		return $this->type;
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
			$var = $this->smarty->getTemplateVars($this->smartyVariable);
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