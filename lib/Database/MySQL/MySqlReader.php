<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class MySqlReader implements IReader
{
	private $_result = null;
	
	public function __construct($result) 
	{
		$this->_result = $result;
	}
	
	public function GetRow() 
	{
		return mysql_fetch_assoc($this->_result);
	}
	
	public function NumRows() 
	{
		return mysql_num_rows($this->_result);
	}
	
	public function Free()
	{
		mysql_free_result($this->_result);
	}
}
?>