<?php
/**
 * Copyright 2014-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/namespace.php');

class FakeAttributeRepository implements IAttributeRepository
{
	/**
	 * @var CustomAttribute
	 */
	public $_CustomAttribute;

	/**
	 * @var CustomAttribute[]
	 */
	public $_CustomAttributes;

	/**
	 * @var AttributeEntityValue[]
	 */
	public $_EntityValues;

	public function __construct()
	{
		$this->_CustomAttribute = new CustomAttribute(1, 'test attribute', CustomAttributeTypes::SINGLE_LINE_TEXTBOX, CustomAttributeCategory::RESERVATION,
													  null, true, null, 0);
		$this->_CustomAttributes = array(
				$this->_CustomAttribute,
				new CustomAttribute(2, 'test attribute2', CustomAttributeTypes::SINGLE_LINE_TEXTBOX, CustomAttributeCategory::RESERVATION, null, true, null, 0),
		);
	}


	/**
	 * @param CustomAttribute $attribute
	 * @return int
	 */
	public function Add(CustomAttribute $attribute)
	{
		// TODO: Implement Add() method.
	}

	/**
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function LoadById($attributeId)
	{
		return $this->_CustomAttribute;
	}

	/**
	 * @param CustomAttribute $attribute
	 */
	public function Update(CustomAttribute $attribute)
	{
		// TODO: Implement Update() method.
	}

	/**
	 * @param $attributeId int
	 * @return void
	 */
	public function DeleteById($attributeId)
	{
		// TODO: Implement DeleteById() method.
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category)
	{
		return $this->_CustomAttributes;
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @param array|int[] $entityIds if null is passed, get all entity values
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds = null)
	{
		return $this->_EntityValues;
	}
}
 