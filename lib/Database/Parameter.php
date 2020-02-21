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

class Parameter
{
	/**
	 * @var string
	 */
	public $Name = null;

	/**
	 * @var mixed
	 */
	public $Value = null;

	public function __construct($name = null, $value = null)
	{
		$this->Name = $name;
		$this->Value = $value;
	}

	public function QuotedValue($value)
    {
        return "'$value'";
    }
}

class ParameterRaw extends Parameter
{
    public function QuotedValue($value)
    {
        return $value;
    }
}