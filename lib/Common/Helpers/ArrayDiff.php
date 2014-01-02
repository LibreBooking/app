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

class ArrayDiff
{
	private $_added = array();
	private $_removed = array();
	private $_unchanged = array();

	public function __construct($array1, $array2)
	{
		$added = array_diff($array2, $array1);
		$removed = array_diff($array1, $array2);
		$unchanged = array_intersect($array1, $array2);

		if (!empty($added))
		{
			$this->_added = array_merge($added);
		}
		if (!empty($removed))
		{
			$this->_removed = array_merge($removed);
		}
		if (!empty($unchanged))
		{
			$this->_unchanged = array_merge($unchanged);
		}
	}

	public function AreDifferent()
	{
		return !empty($this->_added) || !empty($this->_removed);
	}

	public function GetAddedToArray1()
	{
		return $this->_added;
	}

	public function GetRemovedFromArray1()
	{
		return $this->_removed;
	}

	public function GetUnchangedInArray1()
	{
		return $this->_unchanged;
	}
}
?>