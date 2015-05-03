<?php
/**
Copyright 2012-2015 Nick Korbel

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

class AttributeEntityValue
{
	/**
	 * @var int
	 */
	public $AttributeId;

	/**
	 * @var mixed
	 */
	public $Value;

	/**
	 * @var int
	 */
	public $EntityId;

	/**
	 * @param $attributeId int
	 * @param $entityId int
	 * @param $value mixed
	 */
	public function __construct($attributeId, $entityId, $value)
	{
		$this->AttributeId = $attributeId;
		$this->Value = trim($value);
		$this->EntityId = $entityId;
	}

	public function __toString()
	{
		return sprintf("AttributeEntityValue attributeid:%s entityid:%s value:%s", $this->AttributeId, $this->EntityId, $this->Value);
	}
}

?>