<?php

/**
 * Copyright 2012-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @return bool
	 */
	public function Required()
	{
		return $this->attributeDefinition->Required();
	}

    /**
     * @return bool
     */
	public function AdminOnly()
    {
        return $this->attributeDefinition->AdminOnly();
    }

	/**
	 * @return int
	 */
	public function SortOrder()
	{
		return $this->attributeDefinition->SortOrder();
	}

	/**
	 * @param $value mixed
	 */
	public function SetValue($value)
	{
		$this->value = $value;
	}

	/**
	 * @return bool
	 */
	public function UniquePerEntity()
	{
		return $this->attributeDefinition->UniquePerEntity();
	}

	/**
	 * @return CustomAttributeCategory|int|null
	 */
	public function SecondaryCategory()
	{
		return $this->attributeDefinition->SecondaryCategory();
	}

	/**
	 * @return int[]|null
	 */
	public function SecondaryEntityId()
	{
		return $this->attributeDefinition->SecondaryEntityIds();
	}
}