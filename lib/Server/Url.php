<?php
/**
Copyright 2012-2019 Nick Korbel

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

class Url
{
    /**
     * @var string
     */
    private $url = '';

    /**
     * @var bool
     */
    private $hasQuestionMark = false;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->hasQuestionMark = BookedStringHelper::Contains($url, '?');
    }

	/**
	 * @param $urlFragment string
	 * @return Url
	 */
	public function Add($urlFragment)
	{
		if (!BookedStringHelper::EndsWith($this->url, '/'))
		{
			$this->url .= '/';
		}

		$this->url .= urlencode($urlFragment);

		return $this;
	}

    /**
     * @param string $name
     * @param string $value
     * @return Url
     */
    public function AddQueryString($name, $value)
    {
        $char = '?';
        if ($this->hasQuestionMark)
        {
            $char = '&';
        }

        $this->hasQuestionMark = true;
        $this->url .= sprintf("$char%s=%s", $name, urlencode($value));

        return $this;
    }

    /**
     * @return string
     */
    public function ToString()
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return $this->url;
    }

    /**
     * @return Url
     */
    public function Copy()
    {
        return new Url($this->ToString());
    }

}

