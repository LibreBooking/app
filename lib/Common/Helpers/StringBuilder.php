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

class StringBuilder
{
	private $_string = array();

	public function Append($string)
	{
		$this->_string[] = $string;
	}

	public function AppendLine($string = '')
	{
		$this->_string[] = $string . "\n";
	}

	public function PrependLine($string = '')
	{
		array_unshift($this->_string, $string . "\n");
	}

	public function Count()
	{
		return count($this->_string);
	}

	public function ToString($glue = '')
	{
		return join($glue, $this->_string);
	}
}