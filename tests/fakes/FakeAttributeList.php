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

class FakeAttributeList implements IEntityAttributeList
{
	private $_attributes = array();
	private $_entityAttributes = array();

	/**
	 * @param array|Attribute[] $attributes
	 */
	public function __construct($attributes = array())
	{
		$this->_attributes = $attributes;
	}

	/**
	 * @return array|string[]
	 */
	public function GetLabels()
	{
		// TODO: Implement GetLabels() method.
	}

	/**
	 * @param null $entityId
	 * @return array|CustomAttribute[]
	 */
	public function GetDefinitions($entityId = null)
	{
		// TODO: Implement GetDefinitions() method.
	}

	/**
	 * @param $entityId int|null
	 * @return array|Attribute[]
	 */
	public function GetAttributes($entityId = null)
	{
		if (array_key_exists($entityId, $this->_entityAttributes))
		{
			return $this->_entityAttributes[$entityId];
		}
		return $this->_attributes;
	}

	public function Add($entityId, $attribute)
	{
		$this->_entityAttributes[$entityId][] = $attribute;
	}
}

?>