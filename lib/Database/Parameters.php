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

class Parameters
{
	private $_parameters = array();
	private $_count = 0;

	public function __construct() { }

	public function Add(Parameter &$parameter)
	{
		$this->_parameters[] = $parameter;
		$this->_count++;
	}

	public function Remove(Parameter &$parameter)
	{
		for ($i = 0; $i < $this->_count; $i++) {
			if ($this->_parameters[$i] == $parameter) {
				$this->removeAt($i);
			}
		}
	}

	public function RemoveAt($index)
	{
		unset($this->_parameters[$index]);
		$this->_parameters = array_values($this->_parameters);	// Re-index the array
		$this->_count--;
	}

	/**
	 * @param $index
	 * @return Parameter
	 */
	public function &Items($index)
	{
		return $this->_parameters[$index];
	}

	public function Count()
	{
		return $this->_count;
	}
}
