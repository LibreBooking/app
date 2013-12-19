<?php
/**
Copyright 2013 Nick Korbel

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

class ContrastingColor
{
	/**
	 * @var string|null
	 */
	private $sourceColor;

	public function __construct($sourceColor)
	{
		$this->sourceColor = $sourceColor;
	}

	public function GetHex(){
		// http://24ways.org/2010/calculating-color-contrast/
		$r = hexdec(substr($this->sourceColor,0,2));
		$g = hexdec(substr($this->sourceColor,2,2));
		$b = hexdec(substr($this->sourceColor,4,2));
		$yiq = (($r*299)+($g*587)+($b*114))/1000;
		return ($yiq >= 128) ? '#333333' : '#E0E0E0';
	}

	public function __toString()
	{
		return $this->GetHex();
	}
}

?>