<?php
/**
Copyright 2011-2019 Nick Korbel

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

class Mdb2Reader implements IReader
{
	private $_result = null;

	/**
	* Takes a PEAR MDB2_Result object to abstract its methods
	* @param MDB2_Result $MDB2_Result
	*/
	public function __construct(&$MDB2_Result)
	{
		$this->_result = $MDB2_Result;
	}

	public function GetRow()
	{
		return $this->_result->fetchRow();
	}

	public function NumRows()
	{
		return $this->_result->numRows();
	}

	public function Free()
	{
		$this->_result->free();
	}
}
