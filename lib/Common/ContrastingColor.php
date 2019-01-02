<?php
/**
Copyright 2013-2019 Nick Korbel

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

class ContrastingColor
{
	/**
	 * @var string|null
	 */
	private $sourceColor;

	public function __construct($sourceColor)
	{
		$this->sourceColor = str_replace('#', '', $sourceColor);
	}

	public function GetHex(){
		// http://24ways.org/2010/calculating-color-contrast/
		$r = hexdec(substr($this->sourceColor,0,2));
		$g = hexdec(substr($this->sourceColor,2,2));
		$b = hexdec(substr($this->sourceColor,4,2));
		$yiq = (($r*299)+($g*587)+($b*114))/1000;
		return ($yiq >= 128) ? '#000000' : '#FFFFFF';
	}

	public function __toString()
	{
		return $this->GetHex();
	}
}

class AdjustedColor
{
    /**
     * @var string|null
     */
    private $sourceColor;

    /**
     * @var string|null
     */
    private $steps;

    public function __construct($sourceColor, $steps = 50)
    {
        $this->sourceColor = str_replace('#', '', $sourceColor);
        $this->steps = $steps;
    }

    public function GetHex(){
        if(!preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $this->sourceColor, $parts))
        {
            return '';
        }
        $out = ""; // Prepare to fill with the results
        for($i = 1; $i <= 3; $i++) {
            $parts[$i] = hexdec($parts[$i]);
            $parts[$i] = round($parts[$i] * $this->steps/100); // 80/100 = 80%, i.e. 20% darker
            // Increase or decrease it to fit your needs
            $out .= str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
        }
        return '#' . $out;
    }

    public function __toString()
    {
        return $this->GetHex();
    }
}