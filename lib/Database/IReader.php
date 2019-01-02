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

interface IReader
{
	/**
	 * Returns the next row in the reader
	 * @return array list of key-value pairs
	 */
	public function GetRow();

	/**
	 * @return int number of rows
	 */
	public function NumRows();

	/**
	 * Releases all rows held by the reader
	 * @return void
	 */
	public function Free();
}

