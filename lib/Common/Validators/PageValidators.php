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


class PageValidators
{
	/**
	 * @var array|IValidator[]
	 */
	private $validators = array();

	/**
	 * @var bool
	 */
	private $isValidated = false;

	/**
	 * @var SmartyPage
	 */
	private $page;

	public function __construct(SmartyPage $page)
	{
		$this->page = $page;
	}

	public function Register($id, $validator)
	{
		$this->validators[$id] = $validator;
	}

	public function Validate()
	{
		foreach($this->validators as $id => $validator)
		{
			$validator->Validate();

			if (!$validator->IsValid())
			{
				$this->page->AddFailedValidation($id, $validator);
			}
		}

		$this->isValidated = true;
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