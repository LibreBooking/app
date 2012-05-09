<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class Attribute
{
	/**
	 * @var CustomAttribute
	 */
	private $attributeDefinition;

	/**
	 * @var mixed
	 */
	private $value;

	public function __construct(CustomAttribute $attributeDefinition, $value = null)
	{
		$this->attributeDefinition = $attributeDefinition;
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function Label()
	{
		return $this->attributeDefinition->Label();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->attributeDefinition->Id();
	}

	/**
	 * @return mixed
	 */
	public function Value()
	{
		return $this->value;
	}

	/**
	 * @return CustomAttributeTypes|int
	 */
	public function Type()
	{
		return $this->attributeDefinition->Type();
	}

	/**
	 * @return array|string[]
	 */
	public function PossibleValueList()
	{
		return $this->attributeDefinition->PossibleValueList();
	}

	/**
	 * @return boolean
	 */
	public function Required()
	{
		return $this->attributeDefinition->Required();
	}
}

?>