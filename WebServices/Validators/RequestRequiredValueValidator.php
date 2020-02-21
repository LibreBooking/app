<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class RequestRequiredValueValidator extends RequiredValidator
{
	private $attributeName;

	/**
	 * @param $value mixed
	 * @param $attributeName string
	 */
	public function __construct($value, $attributeName)
	{
		$this->attributeName = $attributeName;
		parent::__construct($value);
	}

	public function Validate()
	{
		parent::Validate();

		if (!$this->IsValid())
		{
			$this->AddMessage($this->attributeName . ' is missing or empty');
		}
	}
}

