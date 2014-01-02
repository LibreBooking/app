<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/


class SmartyTextbox
{
	private $name;
    private $id;
	private $attributes;
	private $smartyVariable;
	private $smarty;

	public function __construct($formKey, $id, $smartyVariable, $attributes, &$smarty)
	{
		$this->name = $this->GetName($formKey);
        $this->id = empty($id) ? $this->GetName($formKey) : $id;
		$this->attributes = $attributes;
		$this->smartyVariable = $smartyVariable;
		$this->smarty = $smarty;
	}

	public function Html()
	{
		$value = $this->GetValue();
		$style = empty($this->style) ? '' : " style=\"{$this->style}\"";

		return "<input type=\"{$this->GetInputType()}\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"$value\" $this->attributes />";
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
?>