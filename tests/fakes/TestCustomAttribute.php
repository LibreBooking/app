<?php

/**
 * Copyright 2012-2014 Nick Korbel
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
class FakeCustomAttribute extends CustomAttribute
{
	/**
	 * @var bool
	 */
	public $_IsRequiredSatisfied = true;

	/**
	 * @var bool
	 */
	public $_IsConstraintSatisfied = true;

	/**
	 * @var mixed
	 */
	public $_RequiredValueChecked;

	/**
	 * @var mixed
	 */
	public $_ConstraintValueChecked;

	/**
	 * @param int $id
	 * @param bool $isRequiredOk
	 * @param bool $isRegexOk
	 * @param int $entityId
	 */
	public function __construct($id = 1, $isRequiredOk = true, $isRegexOk = true, $entityId = null)
	{
		$this->id = $id;
		$this->label = "fakeCustomAttribute$id";
		$this->entityId = $entityId;

		$this->_IsRequiredSatisfied = $isRequiredOk;
		$this->_IsConstraintSatisfied = $isRegexOk;
	}

	public function SatisfiesRequired($value)
	{
		$this->_RequiredValueChecked = $value;
		return $this->_IsRequiredSatisfied;
	}

	public function SatisfiesConstraint($value)
	{
		$this->_ConstraintValueChecked = $value;
		return $this->_IsConstraintSatisfied;
	}

	public function IsAdminOnly($value)
	{
		$this->adminOnly = $value;
	}
}

class TestCustomAttribute extends CustomAttribute
{
	public function __construct($id, $label, $entityId = null)
	{
		$this->id = $id;
		$this->label = $label;
		$this->entityId = $entityId;
	}
}